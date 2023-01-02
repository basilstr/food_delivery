<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->tinyInteger('type_food')->default(1)->comment('1-порційна 2-вагова');
            $table->tinyInteger('food_ingredient')->default(1)->comment('1-блюдо 2-інгредієнт, 3-блюдо+інградієнт');
            $table->text('description')->nullable()->comment('опис блюда / товару');
            $table->text('description_design')->nullable()->comment('json опис полів в дизайні додатку');
            $table->integer('weight')->nullable()->comment('вага в грамах за одиницю товару');
            $table->integer('amount')->nullable()->comment('кількість елементів в порції / упаковці, що має вказану вагу weight');
            $table->decimal('price', 10,2)->nullable()->comment('ціна загалом за вказану вагу weight');
            $table->tinyInteger('status')->default(1);
            $table->text('work_schedule')->nullable()->comment('графік роботи');
            $table->tinyInteger('promote_status')->default(0);
            $table->text('promote_description')->nullable()->comment('опис акції');
            $table->text('promote_schedule')->nullable();
            $table->integer('sort')->nullable();
            $table->timestamps();

            $table->index('provider_id');
            $table->index('food_ingredient');
            $table->index('price');
            $table->index('sort');

            $table->foreign('provider_id')->references('id')->on('providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
}
