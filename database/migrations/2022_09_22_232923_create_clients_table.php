<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 12);
            $table->string('name');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('address')->comment('адреса по замовчуванню');
            $table->string('notes')->comment('примітки');
            $table->boolean('in_black_list');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->index('account_id');
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
        Schema::dropIfExists('clients');
    }
}
