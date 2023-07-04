<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorDailyHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_daily_hours', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('sun')->nullable();
            $table->string('mon')->nullable();
            $table->string('tue')->nullable();
            $table->string('wed')->nullable();
            $table->string('thu')->nullable();
            $table->string('fri')->nullable();
            $table->string('sat')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('vendor_daily_hours');
    }
}
