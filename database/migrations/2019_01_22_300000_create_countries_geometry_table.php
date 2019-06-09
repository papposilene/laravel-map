<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesGeometryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries_geometry', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('country_uuid');
            $table->geometryCollection('geometry')->nullable();
            $table->foreign('country_uuid')->references('uuid')->on('countries');
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
        Schema::dropIfExists('countries_geometry');
    }
}
