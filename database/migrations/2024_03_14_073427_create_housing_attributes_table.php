<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousingAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('housing_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained('houses')->onDelete('cascade');
            $table->string('metro')->nullable();
            $table->integer('rooms')->nullable();
            $table->text('description')->nullable();
            $table->integer('fridge')->default(0)->nullable();
            $table->integer('dishwasher')->default(0)->nullable();
            $table->integer('clothWasher')->default(0)->nullable();
            $table->integer('balcony')->default(0)->nullable();
            $table->integer('bathroom')->default(0)->nullable();
            $table->integer('pledge')->default(0)->nullable();
            $table->string('infrastructure')->nullable();
            $table->string('author');
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
        Schema::dropIfExists('housing_attributes');
    }
}
