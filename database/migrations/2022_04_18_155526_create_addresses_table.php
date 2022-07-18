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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->foreignId('state_id');
            $table->string('city');
            $table->string('zip_code');
            $table->string('neighborhood');
            $table->string('street');
            $table->string('ext_no');
            $table->string('int_no')->nullable();
            $table->text('notes')->nullable();
            $table->morphs('addressable');
            $table->enum('type', ['shipping', 'billing', 'both'])->nullable();
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
        Schema::dropIfExists('addresses');
    }
};
