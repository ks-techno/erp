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
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('down_payment', 10, 2)->change();
            $table->decimal('on_balloting', 10, 2)->change();
            $table->decimal('on_possession', 10, 2)->change();
            $table->decimal('sale_discount', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->double('down_payment', 8, 2)->change();
            $table->double('on_balloting', 8, 2)->change();
            $table->double('on_possession', 8, 2)->change();
            $table->double('sale_discount', 8, 2)->change();
        });
    }
};
