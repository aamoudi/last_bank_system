<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_operations', function (Blueprint $table) {
            $table->id();
            $table->morphs('source');
            $table->morphs('destination');
            $table->float('amount');
            $table->boolean('verified')->default(false);
            $table->string('verification_code', 45)->nullable();
            $table->date('date');
            $table->time('time');

            $table->foreignId('operation_by_user_id');
            $table->foreign('operation_by_user_id')->on('users')->references('id');

            $table->foreignId('currency_id');
            $table->foreign('currency_id')->on('currencies')->references('id');

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
        Schema::dropIfExists('financial_operations');
    }
}
