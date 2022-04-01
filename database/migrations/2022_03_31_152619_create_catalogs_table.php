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
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('year_id');
            $table->foreignId('make_id');
            $table->foreignId('model_id');
            $table->foreignId('engine_id')->nullable();
            $table->text('notes')->nullable();
            $table->jsonb('attributes')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('make_id')->references('id')->on('manufacturers');
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('engine_id')->references('id')->on('engines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogs');
    }
};