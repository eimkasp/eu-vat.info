<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SiteBreadcrumbs extends Component
{
    public function __construct(
        public array $items,
        public string $variant = 'light',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.breadcrumbs');
    }
}
