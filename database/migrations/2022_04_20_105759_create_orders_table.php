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
            $table->uuid('id')->primary();
            $table->foreignId('user_id');
            $table->foreignId('status_id');
            $table->float('subtotal', 10, 2);
            $table->float('discount', 10, 2)->default(0);
            $table->float('tax', 10, 2);
            $table->float('total', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->foreignUuid('order_id');
            $table->foreignId('product_id');
            $table->float('quantity');
            $table->float('subtotal', 10, 2);
            $table->float('discount', 10, 2)->default(0);
            $table->float('tax', 10, 2);
            $table->float('total', 10, 2);

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('orders');
    }
};
