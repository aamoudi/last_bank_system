<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debits', function (Blueprint $table) {
            $table->id();
            $table->string('title', 45);
            $table->float('total');
            $table->float('remain');
            $table->string('image')->nullable();
            $table->enum('type', ['Creditor', 'Debtor']);
            $table->enum('payment_type', ['Single', 'Multi']);
            $table->string('details')->nullable();
            $table->date('date');

            $table->foreignId('user_id');
            $table->foreign('user_id')->on('users')->references('id');

            $table->foreignId('currecny_id');
            $table->foreign('currecny_id')->on('currencies')->references('id');

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
        Schema::dropIfExists('debits');
    }
}
