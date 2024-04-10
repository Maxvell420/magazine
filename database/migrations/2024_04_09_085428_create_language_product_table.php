<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_product', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('product_id');
            $table->json('properties');
            $table->timestamps();

            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_product');
    }
}
