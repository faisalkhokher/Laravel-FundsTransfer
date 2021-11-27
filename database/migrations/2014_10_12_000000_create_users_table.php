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
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('social_code')->nullable();
            $table->string('swiss_code')->nullable();
            $table->string('email')->unique();
            $table->string('device_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('promo_code')->nullable();
            $table->string('avatar')->nullable();
            $table->string('company_name')->nullable();
            $table->string('paddle_access_token')->nullable();
            $table->string('license_image')->nullable();
            $table->enum('status' , ['clear' , 'pending' ,'completed'])->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_account_id')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->rememberToken();
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
