<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('min_price')->nullable()->after('name')->comment('мінімальне замовлення');
            $table->string('description')->nullable()->after('name')->comment('короткий опис закладу');
            $table->integer('total_votes')->default(0)->after('rating')->comment('загальна кількість голосів');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('min_price');
            $table->dropColumn('description');
            $table->dropColumn('total_votes');
        });
    }
}
