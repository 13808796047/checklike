<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDevWeappOpenidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('dev_weapp_openid')->unique()->nullable();
            $table->string('wf_weapp_openid')->unique()->nullable();
            $table->string('wp_weapp_openid')->unique()->nullable();
            $table->string('pp_weapp_openid')->unique()->nullable();
            $table->string('cn_weapp_openid')->unique()->nullable();
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
            $table->dropColumn('dev_weapp_openid');
            $table->dropColumn('wf_weapp_openid');
            $table->dropColumn('wp_weapp_openid');
            $table->dropColumn('pp_weapp_openid');
            $table->dropColumn('cn_weapp_openid');
        });
    }
}
