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
        Schema::create('challan_particular', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('challan_id');
            $table->unsignedBigInteger('particular_id');
            $table->string('amount');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('challan_id')->references('id')->on('challan_form')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('particular_id')->references('id')->on('particulars')
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
        Schema::dropIfExists('challan_particular');
    }
};
