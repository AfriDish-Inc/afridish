<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('login_type')->nullable();
            $table->string('social_id')->nullable();
            $table->integer('is_adult')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('user_type')->nullable();
            $table->string('device_type')->nullable();
            $table->string('firebase_token')->nullable();
            $table->string('mobile_number')->nullable();
            $table->text('user_address')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_verified')->nullable();
            $table->string('last_login')->nullable();
            $table->string('cart_product_type')->nullable();
            $table->string('remember_token')->nullable();
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
