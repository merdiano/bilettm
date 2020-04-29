<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddPaymentInfoToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_card_pan')->nullable();
            $table->string('payment_card_expiration')->nullable();
            $table->string('payment_card_holder_name')->nullable();
            $table->unsignedTinyInteger('payment_order_status')->nullable();
            $table->unsignedTinyInteger('payment_error_code')->nullable();
            $table->string('payment_error_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_card_pan');
            $table->dropColumn('payment_card_expiration');
            $table->dropColumn('payment_card_holder_name');
            $table->dropColumn('payment_order_status');
            $table->dropColumn('payment_error_code');
            $table->dropColumn('payment_error_message');
        });
    }
}
