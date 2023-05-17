<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $groupedDates = $this->ticket_dates->groupBy(function ($item) {
            return $item->event_id . '_' . substr($item->ticket_date, 0, 10);
        })->map(function ($group) {
            $firstTicket = $group->first();

            return [
                'ticket_date' => $firstTicket->ticket_date,
                'hours' => $group->map(function ($event) {
                    return substr($event->ticket_date, 11, 8);
                })->toArray(),
            ];
        })->values();
        return [
            'id'            => $this->id,
            'title_tk'      => $this->title_tk,
            'title_ru'      => $this->title_ru,
            'img_url'       => $this->image_url,
            'description'   => $this->description,
            'ticket_dates'  => $groupedDates,
            'views'         => $this->views
        ];
    }
}
