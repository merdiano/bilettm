<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketDateResource extends JsonResource
{
    public function __construct($ticket_dates)
    {
        // Ensure you call the parent constructor
        $resource['ticket_dates'] = $ticket_dates;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        

        // return [
        //     'ticket_dates' => $groupedDates,
        // ];
    }
}
