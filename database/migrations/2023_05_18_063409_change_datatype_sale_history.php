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
        Schema::table('sale_histories', function (Blueprint $table) {
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
        //
    }
};
