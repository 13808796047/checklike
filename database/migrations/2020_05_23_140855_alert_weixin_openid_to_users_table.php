<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertWeixinOpenidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropUnique('users_dev_weixin_openid_unique');
            $table->dropUnique('users_wf_weixin_openid_unique');
            $table->dropUnique('users_wp_weixin_openid_unique');
            $table->dropUnique('users_pp_weixin_openid_unique');
            $table->dropUnique('users_cn_weixin_openid_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->unique('dev_weixin_openid');
            $table->unique('wf_weixin_openid');
            $table->unique('wp_weixin_openid');
            $table->unique('pp_weixin_openid');
            $table->unique('cn_weixin_openid');
        });
    }
}
