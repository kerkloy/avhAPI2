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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('prodName');
            $table->string('prodType');
            $table->string('prodBrand');
            $table->integer('ordQty');
            $table->decimal('prodOPrice');
            $table->decimal('prodSPrice');
            $table->decimal('totalOrderPrice');
            $table->date('ordDate');
            $table->integer('status')->default(0)->nullable(); //0-pending 1-recieved
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
        Schema::dropIfExists('orders');
    }
};
