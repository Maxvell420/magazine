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
            $table->boolean('fridge')->default(0);
            $table->boolean('dishwasher')->default(0);
            $table->boolean('clothWasher')->default(0);
            $table->integer('balcony')->nullable();
            $table->integer('bathroom')->nullable();
            $table->integer('pledge')->nullable();
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
