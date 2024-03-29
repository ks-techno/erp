<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['customers', 'staffs', 'dealers','suppliers','manufacturers'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->bigInteger('COAID')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multiple_accounts', function (Blueprint $table) {
            //
        });
    }
};
