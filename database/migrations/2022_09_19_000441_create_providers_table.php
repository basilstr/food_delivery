<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->text('aliases')->nullable()->comment('варіанти назви закладу - використовується для пошуку');
            $table->string('logo')->default('');
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->integer('city_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('address')->nullable();
            $table->unsignedBigInteger('account_id')->unsigned()->nullable();
            $table->text('work_schedule')->nullable()->comment('графік роботи');
            $table->string('type_pay')->nullable()->comment('способи оплати');
            $table->string('type_delivery')->nullable()->comment('способи доставки');
            $table->text('about')->nullable()->comment('про заклад');
            $table->string('rating')->nullable()->comment('загальний рейтинг по результатам оцінок користувачів');
            $table->integer('sort')->default(1);
            $table->timestamps();

            $table->index('city_id');
            $table->index('status');
            $table->index('account_id');
            $table->index('sort');

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
        Schema::dropIfExists('providers');
    }
}
