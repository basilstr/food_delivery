<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();
            $table->string('password')->nullable(false);
            $table->string('role')->nullable();
            $table->string('name')->default('');
            $table->string('avatar')->default('');
            $table->tinyInteger('status')->default(1);
            $table->integer('city_id')->nullable();
            $table->timestamp('last_active');
            $table->unsignedBigInteger('account_id')->unsigned()->nullable();
            $table->unsignedBigInteger('provider_id')->unsigned()->nullable()->comment('id закладу');
            $table->rememberToken();
            $table->timestamps();

            $table->index('login');
            $table->index('account_id');
            $table->index('provider_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
