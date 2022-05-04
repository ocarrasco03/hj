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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id');
            $table->foreignId('status_id')->default(1);
            $table->string('sku');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('slug')->unique();
            $table->float('cost', 16, 10)->unsigned();
            $table->float('price_wo_tax', 16, 10)->unsigned();
            $table->float('price', 16, 10)->unsigned();
            $table->string('unit')->default('pza');
            $table->float('stock')->unsigned()->default(0);
            $table->float('weight')->unsigned()->default(0);
            $table->text('notes')->nullable();
            $table->jsonb('attributes')->nullable();
            $table->string('condition')->default('new');
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });

        Schema::create('related_products', function (Blueprint $table) {
            $table->foreignId('product_id');
            $table->foreignId('related_id');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('related_id')->references('id')->on('products');
        });

        Schema::create('products_categories', function (Blueprint $table) {
            $table->foreignId('product_id');
            $table->foreignId('category_id');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_categories');
        Schema::dropIfExists('products');
    }
};
