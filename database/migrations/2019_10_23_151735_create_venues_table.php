<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $t) {
            $t->increments('id');
            $t->string('venue_name');
            $t->string('venue_name_full')->nullable();
            $t->string('location_address', 355)->nullable();
            $t->string('location_address_line_1', 355);
            $t->string('location_address_line_2', 355);
            $t->string('location_country')->nullable();
            $t->string('location_country_code')->nullable();
            $t->string('location_state');
            $t->string('location_post_code');
            $t->string('location_street_number')->nullable();
            $t->string('location_lat')->nullable();
            $t->string('location_long')->nullable();
            $t->string('location_google_place_id')->nullable();
            $t->string('seats_image')->nullable();
            $t->boolean('active')->default(1);
            $t->json('address')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('venues');
    }
}
