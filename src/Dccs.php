<?php

namespace SuperBadCN\CustomConfig;

use SuperBadCN\CustomConfig\Models\CustomConfig;

class Dccs
{
    protected $config;
    /**
     * 获取配置
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (is_array($key)) {
            $custom_configs = CustomConfig::whereIn('key', $key)->get();
            $result = [];
            foreach ($custom_configs as $key => $custom_config) {
                $result[$custom_config->key] = $custom_config->value;
            }
            return $result;
        }
        $custom_config = CustomConfig::with('items')->where('key', $key)->first();
        return $custom_config->value;
    }

    /**
     * 设置配置,目前只支持设置文本，TODO:支持设置更多类型
     * @param $key
     * @return mixed
     */
    public function set($key, $value)
    {
        CustomConfig::where('key', $key)->updateOrCreate(
            [
                'key' => $key
            ],
            [
                'type' => 1,
                'value' => $value
            ]
        );
    }
}
