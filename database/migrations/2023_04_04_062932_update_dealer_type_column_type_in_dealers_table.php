<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDealerTypeColumnTypeInDealersTable extends Migration
{
    public function up()
    {
        Schema::table('dealers', function (Blueprint $table) {
            $table->string('dealer_type')->change();
        });
    }

    public function down()
    {
        Schema::table('dealers', function (Blueprint $table) {
            $table->enum('dealer_type', ['main', 'sub'])->change();
        });
    }
}
