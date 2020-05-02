<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpTicketCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_ticket_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->string('attachment')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name')->nullable();
            $table->unsignedInteger('help_ticket_id');
            $table->foreign('help_ticket_id')->references('id')->on('help_tickets')->onDelete('cascade');
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
        Schema::drop('help_ticket_comments');
    }
}
