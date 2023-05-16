<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    public function __construct($sliders, $events)
    {
        // Ensure you call the parent constructor
        $resource['sliders'] = $sliders;
        $resource['events'] = $events;
        parent::__construct($resource);
        $this->resource = $resource;
    }

    public function toArray($request)
    {
        return [
            'sliders'   => SliderResource::collection($this['sliders']),
            'events'    => EventResource::collection($this['events'])
        ];
    }
}
