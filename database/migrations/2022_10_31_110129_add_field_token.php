<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('api_token_expiration')->nullable()->after('status');
            $table->string('api_token')->nullable()->after('status');
        });

        Schema::table('couriers', function (Blueprint $table) {
            $table->timestamp('api_token_expiration')->nullable()->after('status');
            $table->string('api_token')->nullable()->after('status');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->timestamp('api_token_expiration')->nullable()->after('status');
            $table->string('api_token')->nullable()->after('status');

            $table->timestamp('sms_code_send')->nullable()->after('phone')->comment('час відправлення СМС коду');
            $table->string('sms_code', 12)->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('api_token');
            $table->dropColumn('api_token_expiration');
            $table->dropColumn('sms_code_send');
            $table->dropColumn('sms_code');
        });
    }
}
