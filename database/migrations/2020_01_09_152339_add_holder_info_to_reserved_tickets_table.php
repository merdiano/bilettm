<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHolderInfoToReservedTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reserved_tickets', function (Blueprint $table) {
//            $table->string('holder_name')->nullable();
//            $table->string('holder_surname')->nullable();
//            $table->string('holder_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reserved_tickets', function (Blueprint $table) {
//            $table->dropColumn('holder_name');
//            $table->dropColumn('holder_surname');
//            $table->dropColumn('holder_email');
        });
    }
}
