<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_food_id');
            $table->unsignedBigInteger('ingredient_food_id');
            $table->integer('weight')->nullable()->comment('вага в грамах за одиницю товару');
            $table->integer('amount')->nullable()->comment('кількість елементів в порції / упаковці, що має вказану вагу weight');
            $table->decimal('price', 10,2)->nullable()->comment('ціна загалом за вказану вагу weight');
            $table->decimal('price_package', 10,2)->nullable()->comment('ціна загалом за вказану вагу weight');
            $table->tinyInteger('can_change')->default(1)->comment('1-завжди включений 2-включений по замовчуванню 3-виключений по замовчуванню');
            $table->tinyInteger('type_change')->default(1)->comment('1-radio 2-checkbox 3-none');
            $table->tinyInteger('status')->default(1);
            $table->text('work_schedule')->nullable()->comment('графік роботи');
            $table->tinyInteger('promote_status')->default(1);
            $table->text('promote_description')->nullable()->comment('опис акції');
            $table->text('promote_schedule')->nullable();
            $table->integer('sort')->nullable();
            $table->timestamps();

            $table->index('parent_food_id');
            $table->index('ingredient_food_id');
            $table->index('status');
            $table->index('sort');

            $table->foreign('parent_food_id')->references('id')->on('food');
            $table->foreign('ingredient_food_id')->references('id')->on('food');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
}
