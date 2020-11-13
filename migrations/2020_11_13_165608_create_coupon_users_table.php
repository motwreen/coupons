<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_users', function (Blueprint $table) {
            $table->string('user_type');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('coupon_id');


            $table->primary(['user_type','user_id','coupon_id'], 'coupon_users_primary_key');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_users');
    }
}
