<?php

namespace SuperBadCN\CustomConfig;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class CustomConfigsServiceProvider extends ServiceProvider
{
	protected $type = self::TYPE_THEME;

	protected $css = [
		'css/index.css',
	];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		//
		Admin::baseCss($this->formatAssetFiles($this->css));
	}

    // 定义菜单
    protected $menu = [
        [
            'title' => '配置管理',
            'uri'   => 'dact-custom-configs',
            'icon'  => 'fa-gears', // 图标可以留空
        ],
    ];
}
