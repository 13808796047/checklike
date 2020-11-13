<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivedAtToCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_codes', function(Blueprint $table) {
            $table->dateTime('actived_at')->nullable()->comment('激活时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_codes', function(Blueprint $table) {
            $table->dropColumn('actived_at');
        });
    }
}
