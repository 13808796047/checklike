<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function(Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('卡号');
            $table->string('type')->comment('类型');
            $table->decimal('value')->nullable()->comment('折扣值');
            $table->unsignedBigInteger('cid')->comment('生效系统')->nullable();
            $table->foreign('cid')->references('id')->on('categories')->onDelete('set null');
            $table->unsignedBigInteger('uid')->comment('会员id')->nullable();
            $table->foreign('uid')->references('id')->on('users')->onDelete('set null');
            $table->decimal('min_amount')->nullable()->comment('生效金额');
            $table->integer('enable_days')->default(0)->comment('有效天数');
            $table->datetime('unabled_date')->comment('失效日期');
            $table->string('status')->default(\App\Models\CouponCode::STATUS_UNACTIVED)->comment('状态');
            $table->string('remark')->nullable()->comment('备注');
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
        Schema::dropIfExists('coupon_codes');
    }
}
