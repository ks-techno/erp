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
        Schema::create('installment_plan', function (Blueprint $table) {
            $table->id();
            $table->biginteger('property_typeID')->nullable();
            $table->biginteger('plan_id')->nullable();
            $table->float('total_payment',15,3)->nullable();
            $table->float('down_payment',15,3)->nullable();
            $table->float('on_balloting',15,3)->nullable();
            $table->float('allocation_amount',15,3)->nullable();
            $table->float('installment_bi_annual')->nullable();
            $table->float('installment_monthly')->nullable();
            $table->float('on_possession',15,3)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installment_plan');
    }
};
