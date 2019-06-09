<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name_eng_common', 255);
            $table->string('name_eng_official', 255);
            $table->string('cca2', 2);
            $table->string('cca3', 3);
            $table->string('cioc', 3);
            $table->json('tlds')->nullable();
            $table->string('ccn3', 3);
            $table->integer('area')->nullable();
            $table->string('region', 255);
            $table->string('subregion', 255)->nullable();
            $table->point('latlng');
            $table->boolean('landlocked')->default(false);
            $table->json('neighbourhood')->nullable();
            $table->string('status', 255)->nullable();
            $table->boolean('independent')->default(true);
            $table->string('flag', 255)->nullable();
            $table->string('currency', 255)->nullable();
            $table->string('capital', 255)->nullable();
            $table->string('demonym', 255)->nullable();
            $table->json('languages')->nullable();
            $table->json('name_native')->nullable();
            $table->json('name_translations')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
