<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 12);
            $table->string('name');
            $table->string('password')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->tinyInteger('type_drive')->nullable();
            $table->string('notes')->comment('примітки');
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
        Schema::dropIfExists('couriers');
    }
}
