<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();
            $table->string('transacton_id')->nullable();
            $table->string('last_four_digit')->nullable();
            $table->string('flw_ref')->nullable();
            $table->string('tx_ref')->nullable();
            $table->string('amount')->nullable();
            $table->string('app_fee')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->string('card_type')->nullable();
            $table->json('payment_responce')->nullable();
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
        Schema::dropIfExists('payment_records');
    }
}
