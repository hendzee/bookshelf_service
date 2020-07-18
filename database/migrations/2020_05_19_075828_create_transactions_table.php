<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('borrower_id');
            $table->string('status');
            $table->string('location_name')->nullable();
            $table->string('map_lat')->nullable();
            $table->string('map_long')->nullable();
            $table->string('map_note')->nullable();
            $table->string('owner_accepted')->nullable();
            $table->string('borrower_accepted')->nullable();
            $table->date('active_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('borrower_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
