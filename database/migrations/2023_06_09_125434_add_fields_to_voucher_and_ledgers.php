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
        $tables = ['vouchers', 'ledgers'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->bigInteger('opening_balance')->nullable();
                $table->bigInteger('closing_balance')->nullable();
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
        Schema::table('voucher_and_ledgers', function (Blueprint $table) {
            //
        });
    }
};
