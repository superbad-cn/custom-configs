<?php

namespace SuperBadCN\CustomConfig;

use SuperBadCN\CustomConfig\Models\CustomConfig;

class Dccs
{
    public function get($key)
    {
        $result = CustomConfig::with('items')->where('key', $key)->first();
        return $result;
    }
}
