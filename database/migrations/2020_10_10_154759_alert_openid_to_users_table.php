<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertOpenidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('dev_weapp_openid');
            $table->dropColumn('wf_weapp_openid');
            $table->dropColumn('wp_weapp_openid');
            $table->dropColumn('pp_weapp_openid');
            $table->dropColumn('cn_weapp_openid');
            $table->dropColumn('dev_weixin_openid');
            $table->dropColumn('wf_weixin_openid');
            $table->dropColumn('wp_weixin_openid');
            $table->dropColumn('pp_weixin_openid');
            $table->dropColumn('cn_weixin_openid');
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
            $table->string('dev_weapp_openid')->nullable();
            $table->string('wf_weapp_openid')->nullable();
            $table->string('wp_weapp_openid')->nullable();
            $table->string('pp_weapp_openid')->nullable();
            $table->string('cn_weapp_openid')->nullable();
            $table->string('dev_weixin_openid', '64')->nullable();
            $table->string('wf_weixin_openid', '64')->nullable();
            $table->string('wp_weixin_openid', '64')->nullable();
            $table->string('pp_weixin_openid', '64')->nullable();
            $table->string('cn_weixin_openid', '64')->nullable();
        });
    }
}
