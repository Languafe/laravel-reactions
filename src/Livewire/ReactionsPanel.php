<?php

declare(strict_types=1);

namespace Languafe\Reactions\Livewire;

use Illuminate\Container\Attributes\Auth;

class ReactionsPanel extends \Livewire\Component
{
    public $model;

    public function react($option)
    {
        $this->model->react($option);
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            @foreach (Reactions::options() as $option)
                <button 
                    wire:click="react('{{ $option }}')" 
                    wire:key="reaction-{{ $option }}" 
                    style="border: 1px solid #ccc; padding: 1px 2px; @if ($this->model->hasReactionFrom(auth()?->user(), $option)) font-weight: bold; @endif"
                >
                    @if (isset($this->model->reactionsKeyed[$option]))
                        {{ $this->model->reactionsKeyed[$option]->count }}
                    @endif
                    {{ $option }}
                </button>
            @endforeach
        </div>
        HTML;
    }
}
