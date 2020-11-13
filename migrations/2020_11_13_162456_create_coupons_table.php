<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->nullable()->default(null);
            $table->text('description');
            $table->string('code')->unique();

            //value & amount
            $table->unsignedInteger('value');
            $table->enum('value_type', ['amount', 'percentage'])->default('amount');

            $table->unsignedInteger('max_amount')->nullable()->default(null)
                ->comment('maximum allowed discount value in case of percentage');

            //Usages
            $table->unsignedInteger('max_total_usages')->nullable()->default(null);
            $table->unsignedInteger('max_user_usages')->nullable()->default(null);

            $table->timestamp('starts_at');
            $table->timestamp('expired_at');
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
        Schema::dropIfExists('coupons');
    }
}
