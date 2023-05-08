<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxToOrganizers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organisers', function($table) {
            $table->string('taxname',15);
            $table->float('taxvalue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organisers', function($table) {
            $table->dropColumn('taxname');
            $table->dropColumn('taxvalue');
        });
    }
}
