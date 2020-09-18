<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('big_project_id')->comment('商品大類id');
            $table->integer('project_id')->comment('商品id');
            $table->integer('size_id')->comment('商品尺寸');
            $table->integer('style_id')->comment('商品樣式');
            $table->integer('num')->index()->comment('商品數量');
            $table->integer('admin')->comment('新增人id');
            $table->integer('amount')->comment('商品價格');
            $table->unique(['big_project_id', 'project_id', 'size_id', 'style_id'] , 'unique_index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_infos');
    }
}
