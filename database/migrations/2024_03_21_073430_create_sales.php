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
            $table->foreignId('prodID');
            $table->string('prodName');
            $table->string('prodBrand');
            $table->string('prodType');
            $table->decimal('prodSPrice');
            $table->decimal('prodOPrice');
            $table->integer('qtySold');
            $table->decimal('totalSales');
            $table->string('custName');
            $table->date('soldDate');
            $table->string('transaction_number')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
