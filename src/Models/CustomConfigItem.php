<?php

namespace SuperBadCN\CustomConfig\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class CustomConfigItem extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'admin_custom_config_items';

    protected $fillable = ['custom_config_id', 'value'];

    public function __construct(array $attributes = [])
    {
        $this->connection = config('database.connection') ?: config('database.default');

        parent::__construct($attributes);
    }
}
