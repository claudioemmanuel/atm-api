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
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('transaction_type_id');
            $table->float('amount', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
