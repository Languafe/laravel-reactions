<?php

declare(strict_types=1);

namespace Languafe\Reactions\Facades;

use Illuminate\Support\Facades\Facade;

class Reactions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Languafe\Reactions\ReactionsManager::class;
    }
}
