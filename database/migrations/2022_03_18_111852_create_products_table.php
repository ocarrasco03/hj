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
            $table->string('sku');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('slug')->unique();
            $table->float('cost', 10, 2)->unsigned();
            $table->float('price_wo_tax', 10, 2)->unsigned();
            $table->float('price', 10, 2)->unsigned();
            $table->string('unit')->default('pza');
            $table->float('stock')->unsigned()->default(0);
            $table->float('weight')->unsigned()->default(0);
            $table->jsonb('notes')->nullable();
            $table->string('condition')->default('new');
            $table->timestamps();
            $table->softDeletes();
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
