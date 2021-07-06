<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('account_id');
            // $table->enum('operation_type', ['withdraw', 'deposit'])->nullable();
            // $table->enum('status', ['in_progress', 'finished']);
            $table->boolean('operation_type')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
