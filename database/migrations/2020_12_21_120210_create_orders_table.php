<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id');
            $table->string('product_id')->nullable();
			$table->integer('paypal_charge_id')->nullable();
            $table->integer('address_id')->nullable();
			$table->date('order_date')->nullable();
			$table->string('order_type')->nullable();
			$table->float('amount',8,2)->nullable();
			$table->string('quantity')->nullable();
			$table->decimal('tax_amount', 8, 2)->nullable();
			$table->integer('tax_percent')->nullable();
			$table->string('shipping_cost')->nullable();
			$table->tinyInteger('order_status')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
