<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('amount')->nullable();

            $table->foreignId('user_id');
            $table->foreign('user_id')->on('users')->references('id');
            
            $table->foreignId('currency_id');
            $table->foreign('currency_id')->on('currencies')->references('id');

            $table->integer('transaction_flag', 1)->default('0');;
            
            $table->boolean('active');
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
        Schema::dropIfExists('income_types');
    }
}
