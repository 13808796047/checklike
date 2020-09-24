<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table) {
            $table->id();
            $table->unsignedInteger('aid')->comment('api_id');
            $table->unsignedInteger('classid')->comment('分类ID');
            $table->string('classname')->nullable()->comment('分类名称');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->string('name')->nullable()->comment('系统名称');
            $table->string('sname')->nullable()->comment('系统简称');
            $table->tinyInteger('price_type')->default(0)->comment('计价方式');
            $table->decimal('price')->default(0.00)->comment('检测单价');
            $table->decimal('agent_price1')->default(0.00)->comment('普通代理价');
            $table->decimal('agent_price2')->default(0.00)->comment('高级代理价');
            $table->tinyInteger('check_type')->default(0)->comment('检测方式');
            $table->bigInteger('min_words')->default(0)->comment('最少字数');
            $table->bigInteger('max_words')->default(0)->comment('最大字数');
            $table->text('intro')->nullable()->comment('系统介绍');
            $table->text('sintro')->nullable()->comment('系统简介');
            $table->string('tese')->nullable()->comment('特色');
            $table->string('seo_title')->nullable()->comment('SEO标题');
            $table->string('sys_logo')->nullable()->comment('系统LOGO');
            $table->string('sys_ico')->nullable()->comment('系统图标');
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
        Schema::dropIfExists('categories');
    }
}
