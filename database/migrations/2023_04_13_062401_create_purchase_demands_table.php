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
        Schema::create('purchase_demands', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('purchaseDemand_id');
            $table->date('date');
            $table->string('uom');
            $table->string('packing');
            $table->bigInteger('sr_no');
            $table->unsignedBigInteger("supplier_id");
            $table->unsignedBigInteger("demandBy_id");
            $table->unsignedBigInteger("product_id");
            $table->bigInteger("physical_stock");
            $table->bigInteger("store_stock");
            $table->string("reorder");
            $table->string("consumption");
            $table->bigInteger("quantity");
            $table->bigInteger("lpo_stock");
            $table->text("notes");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('supplier_id')->references('id')->on('suppliers')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('demandBy_id')->references('id')->on('staffs')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')
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
        Schema::dropIfExists('purchase_demand');
    }
};
