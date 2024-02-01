<?php

namespace SuperBadCN\CustomConfig\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use SuperBadCN\CustomConfig\Models\CustomConfigItem;
use SuperBadCN\CustomConfig\CustomConfigsServiceProvider as Provider;

class CustomConfig extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'admin_custom_configs';

    protected $fillable = ['title', 'key', 'type', 'value1', 'value2', 'value3', 'value4', 'value5', 'value6', 'value7', 'value8', 'value9'];

    protected $casts= [
        'value4' => 'array',
        'value6' => 'array',
        'value7' => 'date',
        'value8' => 'datetime',
    ];

    public static function type()
    {
        $type = [
            1  => '普通文本',
            2  => '富文本',
            3  => '单图',
            4  => '多图',
            5  => '单文件',
            6  => '多文件',
            7  => '日期',
            8  => '日期时间',
            9  => '开关',
            10 => '循环文本',
            11 => '循环富文本',
        ];

        $type_en = [
            1 => 'Text',
            2 => 'Rich Text',
            3 => 'Single Image',
            4 => 'Multiple Images',
            5 => 'Single File',
            6 => 'Multiple Files',
            7 => 'Date',
            8 => 'DateTime',
            9 => 'Switch',
            10 => 'Loop Text',
            11 => 'Loop Rich Text',
        ];
        return Provider::trans('custom-config.language') == 'en' ? $type_en : $type;
    }

    public function __construct(array $attributes = [])
    {
        $this->connection = config('database.connection') ?: config('database.default');

        parent::__construct($attributes);
    }

    public function items()
    {
        return $this->hasMany(CustomConfigItem::class, 'custom_config_id');
    }
}