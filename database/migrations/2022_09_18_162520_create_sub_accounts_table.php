<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->unsigned()->nullable();
            $table->integer('type_account_id');
            $table->decimal('total', 10,2);
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts');

            $table->index('account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('sub_accounts', function (Blueprint $table) {
            $table->dropForeign('sub_accounts_account_id_foreign');
            Schema::dropIfExists('sub_accounts');
        });*/
        Schema::dropIfExists('sub_accounts');
    }
}
