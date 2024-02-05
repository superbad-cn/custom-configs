<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('admin_custom_configs')) {
            Schema::create('admin_custom_configs', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable()->comment('标题');
                $table->string('key')->comment('键');
                $table->tinyInteger('type')->comment('类型');
                $table->text('value1')->nullable()->comment('值');
                $table->text('value2')->nullable()->comment('值');
                $table->text('value3')->nullable()->comment('值');
                $table->text('value4')->nullable()->comment('值');
                $table->text('value5')->nullable()->comment('值');
                $table->text('value6')->nullable()->comment('值');
                $table->text('value7')->nullable()->comment('值');
                $table->text('value8')->nullable()->comment('值');
                $table->text('value9')->nullable()->comment('值');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_custom_configs');
    }
}
