<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title"=> $this->title,
            "text" => $this->text,
            "image" => public_path() . '/' . $this->image,
            "link" => $this->link,
            "active" => $this->active,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "title_ru" => $this->title_ru,
            "text_ru" => $this->text_ru,
            "title_tk" => $this->title_tk,
            "text_tk" => $this->text_tk,
            "ru" => $this->ru,
            "tk" => $this->tk,
            "order" => $this->order
        ];
    }
}
