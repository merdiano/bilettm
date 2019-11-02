<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeatToAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->string('row')->nullable();
            $table->string('no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->dropColumn('row');
            $table->dropColumn('no');
        });
    }
}
