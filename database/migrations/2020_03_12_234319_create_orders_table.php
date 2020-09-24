<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $table) {
            $table->id();
            $table->unsignedInteger('orderid')->comment('订单ID');
            $table->unsignedInteger('cid');
            $table->unsignedInteger('userid');
            $table->tinyInteger('status')->default(0);
            $table->string('title')->nullable();
            $table->string('writer')->nullable();
            $table->text('content')->nullable();
            $table->dateTime('date_publish')->nullable();
            $table->bigInteger('words')->default(0);
            $table->decimal('price')->default(0.00);
            $table->decimal('pay_price')->default(0.00);
            $table->string('pay_type')->nullable();
            $table->string('payid')->nullable();
            $table->dateTime('date_pay');
            $table->string('paper_path')->nullable();
            $table->string('report_path')->nullable();
            $table->decimal('rate')->default(0.00);
            $table->text('result')->nullable();
            $table->string('from')->nullable();
            $table->string('keyword')->nullable();
            $table->unsignedInteger('rid')->nullable();
            $table->string('del')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
