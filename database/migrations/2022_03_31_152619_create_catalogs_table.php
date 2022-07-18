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
            $table->foreignId('year_id');
            $table->foreignId('make_id');
            $table->foreignId('model_id');
            $table->foreignId('engine_id')->nullable();
            $table->text('notes')->nullable();
            $table->jsonb('attributes')->nullable();
            $table->timestamps();

            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('make_id')->references('id')->on('manufacturers');
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('engine_id')->references('id')->on('engines');
        });

        Schema::create('catalog_product', function (Blueprint $table) {
            $table->foreignId('product_id');
            $table->foreignId('catalog_id');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('catalog_id')->references('id')->on('catalogs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_product');
        Schema::dropIfExists('catalogs');
    }
};
