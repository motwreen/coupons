<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couponables', function (Blueprint $table) {
            $table->string('couponable_type');
            $table->unsignedBigInteger('couponable_id');
            $table->unsignedBigInteger('coupon_id');

            $table->primary(['couponable_type','couponable_id','coupon_id'], 'couponables_primary_key');
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
        Schema::dropIfExists('couponables');
    }
}
