<?php

namespace App\Livewire;

use App\Services\BlogPostRepository;
use Livewire\Component;

class BlogIndex extends Component
{
    public function render()
    {
        return view('livewire.blog-index', [
            'posts' => app(BlogPostRepository::class)->all(),
        ]);
    }
}
