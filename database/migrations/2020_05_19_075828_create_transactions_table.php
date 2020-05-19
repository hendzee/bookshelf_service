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
            $table->unsignedBigInteger('item_id');
            $table->string('status');
            $table->string('map_lat');
            $table->string('map_long');
            $table->string('map_note');
            $table->date('active_date');
            $table->date('expired_date');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('borrower_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('items');
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
