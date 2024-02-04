<?php

namespace SuperBadCN\CustomConfig\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SuperBadCN\CustomConfig\DactCustomConfig
 */
class Dccs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'dccs';
    }
}
