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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->string('code');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->unsignedBigInteger('brand_id');
            $table->boolean('is_purchase_able')->default(0);
            $table->boolean('is_taxable')->default(0);
            $table->boolean('status')->default(0);
            $table->bigInteger('default_sale_price')->default(0);
            $table->bigInteger('default_purchase_price')->default(0);
            $table->bigInteger('stock_on_hand_units')->default(0);
            $table->bigInteger('stock_on_hand_packages')->default(0);
            $table->bigInteger('sold_in_quantity')->default(0);
            $table->bigInteger('sell_by_package_only')->default(0);

            $table->foreign('supplier_id')->references('id')->on('suppliers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('brand_id')->references('id')->on('brands')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
};
