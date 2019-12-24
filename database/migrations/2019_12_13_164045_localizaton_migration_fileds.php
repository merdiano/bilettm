<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocalizatonMigrationFileds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('title_ru')->nullable();
            $table->string('title_tk')->nullable();
            $table->text('description_tk')->nullable();
            $table->text('description_ru')->nullable;
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->string('venue_name_ru')->nullable();
            $table->string('venue_name_tk')->nullable();
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->string('section_no_ru')->nullable();
            $table->string('description_ru')->nullable();
            $table->string('section_no_tk')->nullable();
            $table->string('description_tk')->nullable();
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->string('title_ru')->nullable();
            $table->string('text_ru')->nullable();
            $table->string('title_tk')->nullable();
            $table->string('text_tk')->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('title')->nullable();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
