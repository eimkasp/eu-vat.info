(() => {
    const updatePath = '/v1/livewire/update';
    const calculators = new Set(["austria", "belgium", "bulgaria", "croatia", "cyprus", "czech-republic", "denmark", "estonia", "finland", "france", "germany", "greece", "hungary", "iceland", "ireland", "italy", "latvia", "lithuania", "luxembourg", "malta", "netherlands", "norway", "poland", "portugal", "romania", "slovakia", "slovenia", "spain", "sweden", "switzerland", "turkey", "united-kingdom"]);
    const currentPath = location.pathname.replace(/^\/v1(?=\/|$)/, '').replace(/(.)\/$/, '$1') || '/';
    const nativeFetch = window.fetch.bind(window);
    let leaving = false;
    let notice;
    let live;

    const isUpdate = (url) => {
        const target = new URL(url, location.href);

        return target.origin === location.origin && target.pathname === updatePath;
    };

    const reply = (status, data) => new Response(JSON.stringify(data), {
        status,
        headers: { 'Content-Type': 'application/json' },
    });

    const answer = (body) => {
        let components = [];

        try {
            components = JSON.parse(body).components ?? [];
        } catch {
            components = [];
        }

        const slug = components.map((component) => component.updates?.selectedCountrySlug).find((value) => typeof value === 'string');

        if (slug !== undefined && calculators.has(slug)) {
            leaving = true;
            location.assign(`/v1/vat-calculator/${slug}/`);

            return reply(503, {});
        }

        const onlyCalculations = components.length > 0 && components.every((component) =>
            Object.keys(component.updates ?? {}).length === 0
            && (component.calls ?? []).length > 0
            && component.calls.every((call) => call.method === 'calculate'));

        if (onlyCalculations) {
            return reply(200, {
                components: components.map((component) => ({
                    snapshot: component.snapshot,
                    effects: { returns: component.calls.map(() => null) },
                })),
                assets: [],
            });
        }

        return reply(503, {});
    };

    window.fetch = (input, init = {}) => {
        if (!isUpdate(input instanceof Request ? input.url : String(input))) {
            return nativeFetch(input, init);
        }

        return Promise.resolve(answer(init.body));
    };

    const hide = () => {
        if (notice) {
            notice.hidden = true;
        }
    };

    const notify = () => {
        if (!notice) {
            notice = document.createElement('div');
            notice.className = 'v1-archive-notice';
            notice.innerHTML = '<p>Live features such as VAT number checks, search, filters and sign-ups are switched off in this archive. <a></a></p>'
                + '<button type="button" aria-label="Dismiss"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg></button>';
            notice.querySelector('a').href = currentPath;
            notice.querySelector('a').textContent = 'Use them on the current site.';
            notice.querySelector('button').addEventListener('click', hide);
            document.body.append(notice);
        }

        notice.hidden = false;
        live.textContent = '';
        setTimeout(() => {
            live.textContent = 'Live features are switched off in this archive. Use them on the current site.';
        }, 100);
    };

    document.addEventListener('DOMContentLoaded', () => {
        live = document.createElement('div');
        live.className = 'v1-archive-live';
        live.setAttribute('role', 'status');
        document.body.append(live);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            hide();
        }
    });

    document.addEventListener('livewire:init', () => {
        window.Livewire.hook('request', ({ url, fail }) => {
            if (!isUpdate(url)) {
                return;
            }

            fail(({ preventDefault }) => {
                preventDefault();

                if (!leaving) {
                    notify();
                }
            });
        });
    });
})();
