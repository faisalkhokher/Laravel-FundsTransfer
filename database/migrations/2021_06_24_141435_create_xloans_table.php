<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXloansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xloans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lyn_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_with_interest', 10, 2);
            $table->decimal('interest_rate', 10, 2);
            $table->integer('duration');
            $table->integer('dur_revisions')->default(0);
            $table->integer('dur_revisions_limit')->default(2);
            $table->string('promo_code')->nullable();
            $table->string('request_status')->nullable();
            $table->string('request_date')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending','accepted','declined','completed']);
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
        Schema::dropIfExists('xloans');
    }
}
