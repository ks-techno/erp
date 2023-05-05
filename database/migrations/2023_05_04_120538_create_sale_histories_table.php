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
        Schema::create('sale_histories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('code');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('customer_id');
            $table->boolean('sale_by_staff')->default(0);
            $table->boolean('is_installment')->default(0);
            $table->boolean('is_booked')->default(0);
            $table->boolean('is_purchased')->default(0);
            $table->float('sale_price',15,3)->nullable();
            $table->float('booked_price',15,3)->nullable();
            $table->string('currency_note_no');
            $table->float('down_payment')->nullable();
            $table->float('on_balloting')->nullable();
            $table->float('no_of_bi_annual')->nullable();
            $table->float('installment_bi_annual')->nullable();
            $table->float('no_of_month')->nullable();
            $table->float('installment_amount_monthly')->nullable();
            $table->float('on_possession')->nullable();
            $table->unsignedBigInteger('file_status_id');
            $table->float('sale_discount')->nullable();
            $table->bigInteger('seller_commission_perc')->nullable();
            $table->unsignedBigInteger('property_payment_mode_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('file_type')->nullable();
            $table->date('file_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('project_id')->references('id')->on('projects')
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
        Schema::dropIfExists('sale_histories');
    }
};
