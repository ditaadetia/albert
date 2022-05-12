<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // public function toArray($request)
    // {
    //     return parent::toArray($request);
    // }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'equipment_id' => $this->equipment_id,
            'tanggal_ambil' => $this->tanggal_ambil,
            'tanggal_kembali' => $this->tanggal_kembali,
            'status' => $this->status,
            'pembatalan' => $this->pembatalan,
        ];
    }
}
