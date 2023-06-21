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
        Schema::table('installment_plan', function (Blueprint $table) {
            $table->string('uuid')->after('id');
            $table->string('installemnt_plan_name')->nullable();
            $table->biginteger('product_variation_id')->nullable();
            $table->string('product_variation_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment_plan', function (Blueprint $table) {
            //
        });
    }
};
