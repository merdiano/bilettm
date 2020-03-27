<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddDescriptionToVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->text('description_ru')->nullable();
            $table->text('description_tk')->nullable();
            $table->longText('images')->nullable();
            $table->string('venue_name')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('description_ru');
            $table->dropColumn('description_tk');
            $table->dropColumn('images');
            $table->string('venue_name')->nullable(false)->change();
        });
    }
}
