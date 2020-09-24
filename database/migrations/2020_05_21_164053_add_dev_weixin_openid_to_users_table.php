<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDevWeixinOpenidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('dev_weixin_openid', '64')->unique()->nullable();
            $table->string('wf_weixin_openid', '64')->unique()->nullable();
            $table->string('wp_weixin_openid', '64')->unique()->nullable();
            $table->string('pp_weixin_openid', '64')->unique()->nullable();
            $table->string('cn_weixin_openid', '64')->unique()->nullable();
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
            $table->dropColumn('dev_weixin_openid');
            $table->dropColumn('wf_weixin_openid');
            $table->dropColumn('wp_weixin_openid');
            $table->dropColumn('pp_weixin_openid');
            $table->dropColumn('cn_weixin_openid');
        });
    }
}
