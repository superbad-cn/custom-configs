<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomConfigItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('admin_custom_config_items')) {
            Schema::create('admin_custom_config_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('custom_config_id')->comment('配置ID');
                $table->text('value')->nullable()->comment('值');
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
        Schema::dropIfExists('admin_custom_config_items');
    }
}
