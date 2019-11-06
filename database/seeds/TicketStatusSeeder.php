<?php

use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ticket_statuses = [
            [
                'id' => 1,
                'name' => 'Sold Out',
            ],
            [
                'id' => 2,
                'name' => 'Sales Have Ended',
            ],
            [
                'id' => 3,
                'name' => 'Not On Sale Yet',
            ],
            [
                'id' => 4,
                'name' => 'On Sale',
            ],
            [
                'id' => 5,
                'name' => 'Off Sale',
            ],
        ];
        Schema::disableForeignKeyConstraints();
        DB::table('ticket_statuses')->delete();
        Schema::enableForeignKeyConstraints();
        DB::table('ticket_statuses')->insert($ticket_statuses);
    }
}
