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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('customer_id');
            $table->boolean('sale_by_staff');
            $table->morphs('seller');
            $table->bigInteger('project_id');
            $table->bigInteger('product_id');
            $table->boolean('is_installment')->default(false);
            $table->boolean('is_booked')->default(false);
            $table->boolean('is_purchased')->default(false);
            $table->float('sale_price');
            $table->float('booked_price')->nullable();

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale');
    }
};
