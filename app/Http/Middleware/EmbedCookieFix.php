<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reissues the session cookie with SameSite=None; Secure for embed contexts.
 *
 * Problem: browsers refuse to send SameSite=Lax cookies on cross-origin iframe
 * POST requests. Livewire uses POST for all component updates, so when the widget
 * is embedded on a third-party site (e.g. CodePen), every Livewire action fails
 * with "session expired" because the session cookie is stripped by the browser.
 *
 * Solution: this middleware runs as a global (outer) middleware so it sees the
 * fully-built response *after* StartSession and EncryptCookies have run. It
 * patches the session cookie's SameSite attribute to "none" and sets the Secure
 * flag, which tells the browser to include the cookie in all cross-origin requests.
 *
 * Detection:
 *  - On the initial embed page load the URL path matches /public/embed/* etc.
 *  - AllowEmbedding (inner, web-group middleware) stamps session('_embed_context')
 *    so that subsequent Livewire AJAX requests to /livewire/update are also caught
 *    even though their URL doesn't look like an embed route.
 */
class EmbedCookieFix
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Is this an embed page load?
        $isEmbedRoute = $request->is(
            'public/embed',
            'public/embed/*',
            'embed',
            'embed/*',
            'embed/preview/*',
        );

        // Is this a Livewire (or other) request from a session that was started
        // on an embed page?
        $hasEmbedSession = $request->hasSession()
            && $request->session()->get('_embed_context');

        if (! $isEmbedRoute && ! $hasEmbedSession) {
            return $response;
        }

        // Find the session cookie in the response and re-issue it with
        // SameSite=None; Secure so the browser sends it on cross-origin POSTs.
        $sessionName = config('session.cookie');

        foreach ($response->headers->getCookies() as $cookie) {
            if ($cookie->getName() !== $sessionName) {
                continue;
            }

            $response->headers->removeCookie(
                $cookie->getName(),
                $cookie->getPath(),
                $cookie->getDomain(),
            );

            $response->headers->setCookie(
                $cookie->withSameSite('none')->withSecure(true),
            );

            break;
        }

        return $response;
    }
}
