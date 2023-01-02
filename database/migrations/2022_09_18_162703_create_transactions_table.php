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
            $table->unsignedBigInteger('sub_account_from')->unsigned()->nullable();
            $table->decimal('total_from', 10,2);
            $table->unsignedBigInteger('sub_account_to')->unsigned()->nullable();
            $table->decimal('total_to', 10,2);
            $table->decimal('sum', 10,2);
            $table->string('description')->nullable();
            $table->string('extra_param')->nullable();

            $table->timestamps();

            $table->index('sub_account_from');
            $table->index('sub_account_to');

            $table->foreign('sub_account_from')->references('id')->on('sub_accounts');
            $table->foreign('sub_account_to')->references('id')->on('sub_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_sub_account_from_foreign');
            $table->dropForeign('transactions_sub_account_to_foreign');
            Schema::dropIfExists('transactions');
        });*/
        Schema::dropIfExists('transactions');
    }
}
