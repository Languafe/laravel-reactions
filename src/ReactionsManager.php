<?php

declare(strict_types=1);

namespace Languafe\Reactions;

use Illuminate\Support\Facades\Config;

class ReactionsManager
{
    public function options(): array
    {
        return Config::get('reactions.allowed', []);
    }

    public function isAllowed(string $option): bool
    {
        return in_array($option, $this->options(), true);
    }
}
