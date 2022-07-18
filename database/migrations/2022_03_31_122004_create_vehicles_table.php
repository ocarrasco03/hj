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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id');
            $table->foreignId('make_id');
            $table->foreignId('model_id');
            $table->foreignId('engine_id')->nullable();
            $table->timestamps();

            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('make_id')->references('id')->on('manufacturers');
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('engine_id')->references('id')->on('engines');
        });

        Schema::create('product_vehicle', function (Blueprint $table) {
            $table->foreignId('product_id');
            $table->foreignId('vehicle_id');
            $table->text('notes')->nullable();
            $table->jsonb('attributes')->nullable();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_vehicle');
        Schema::dropIfExists('vehicles');
    }
};
