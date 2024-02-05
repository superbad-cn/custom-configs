<?php

namespace SuperBadCN\CustomConfig\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use SuperBadCN\CustomConfig\Models\CustomConfigItem;
use SuperBadCN\CustomConfig\CustomConfigsServiceProvider as Provider;
use Illuminate\Support\Str;

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
            10 => '循环富文本',
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
            10 => 'Loop Rich Text',
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

    /**
     * 获取文件和图片的详细地址
     *
     * @param string $file 图片路径
     * @param boolean $is_more 是否多图
     */
    function getFileUrl($file, $is_more = false)
    {
        // 处理多图
        if($is_more){
            // 判断是否是json，如果是json则转换为数组
            if(is_string($file) && Str::startsWith($file, ['[', '{'])){
                $file = json_decode($file);
            }
            $file_urls = [];
            if (is_array($file) && !empty($file)) {
                foreach ($file as $item) {
                    // 如果 file 字段本身就已经是完整的 url 就直接返回
                    if (Str::startsWith($item, ['http://', 'https://'])) {
                        $file_urls[] = $item;
                    } else {
                        $file_path = storage_path('app/public/' . $item);
                        if (file_exists($file_path)) {
                            $file_urls[] = \Storage::disk('public')->url($item);
                        }else{
                            $file_urls[] = '';
                        }
                    }
                }
            }
            return $file_urls;
        }

        // 处理单图
        if ($file) {
            if (Str::startsWith($file, ['http://', 'https://'])) {
                return $file;
            }
            $file_path = storage_path('app/public/' . $file);
            if (file_exists($file_path)) {
                return \Storage::disk('public')->url($file);
            }
        }
        return '';
    }

    public function getFullImageUrlAttribute()
    {
        return $this->getFileUrl($this->value3);
    }

    public function getFullImageUrlsAttribute()
    {
        if($this->value4){
            return $this->getFileUrl(json_encode($this->value4), true);
        }
        return [];
    }

    public function getFullFileUrlAttribute()
    {
        return $this->getFileUrl($this->value5);
    }

    public function getFullFileUrlsAttribute()
    {
        if($this->value6){
            return $this->getFileUrl(json_encode($this->value4), true);
        }
        return [];
    }

    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 1:
                $value = $this->value1;
                break;
            case 2:
                $value = $this->value2;
                break;
            case 3:
                $value = $this->full_image_url;
                break;
            case 4:
                $value = $this->full_image_urls;
                break;
            case 5:
                $value = $this->full_file_url;
                break;
            case 6:
                $value = $this->full_file_urls;
                break;
            case 7:
                $value = optional($this->value7)->toDateString();
                break;
            case 8:
                $value = optional($this->value8)->toDateTimeString();
                break;
            case 9:
                $value = $this->value9 ? true : false;
                break;
            case 10:
                $value = $this->items->pluck('value')->toArray();
                break;
            default:
                $value = '';
                break;
        }
        return $value;
    }
}
