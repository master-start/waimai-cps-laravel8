<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->string('openid')->nullable();
            $table->string('session_key')->nullable();
            $table->string('mobile')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token',300)->nullable();
            $table->float('sum_take_out_money')->default(0.00)->comment('累计提现');
            $table->float('disavailable_money')->default(0.00)->comment('待结算佣金');
            $table->float('available_money')->default(0.00)->comment('账户余额');
            $table->integer('count_pending_order')->default(0)->comment('待结算订单');
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
        Schema::dropIfExists('users');
    }
}
