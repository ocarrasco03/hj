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
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('make_id');
            $table->string('name')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('make_id')->references('id')->on('manufacturers');
        });

        Schema::create('models_years', function (Blueprint $table) {
            $table->foreignId('model_id');
            $table->foreignId('year_id');

            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('year_id')->references('id')->on('years');
        });

        Schema::create('models_engines', function (Blueprint $table) {
            $table->foreignId('model_id');
            $table->foreignId('year_id');
            $table->foreignId('engine_id');

            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('year_id')->references('id')->on('years');
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
        Schema::dropIfExists('models_years');
        Schema::dropIfExists('models_engines');
        Schema::dropIfExists('models');
    }
};
