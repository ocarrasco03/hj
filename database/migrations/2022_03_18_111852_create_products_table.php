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
            $table->foreignId('supplier_id')->nullable();
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
            $table->jsonb('notes')->nullable();
            $table->string('condition')->default('new');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
