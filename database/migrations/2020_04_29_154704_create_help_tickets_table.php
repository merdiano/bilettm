<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->text('text');
            $table->string('subject');
            $table->string('attachment')->nullable();
            $table->unsignedInteger('ticket_category_id')->nullable();
            $table->foreign('ticket_category_id')->references('id')->on('help_ticket_categories')->onDelete('cascade');
            $table->enum('status',['pending','waiting_replay','solved']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('helpTicket');
    }
}
