<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddExpectsPaymentToReservedTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reserved_tickets', function (Blueprint $table) {
            $table->dateTime('expects_payment_at')->nullable();
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
            $table->dropColumn('expexts_payment_at');
        });
    }
}
