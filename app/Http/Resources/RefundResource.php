<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefundResource extends JsonResource
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
            'order_id' => $this->order_id,
            'tenant_id' => $this->tenant_id,
            'surat_permohonan_refund' => asset('storage/' . $this->surat_permohonan_refund),
            'metode_refund' => $this->metode_refund,
        ];
    }
}
