<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'foto' => asset('storage/' . $this->foto),
            'nama' => $this->nama,
            'jenis' => $this->jenis,
            'kegunaan' => $this->kegunaan,
            // 'total' => $this->total,
            // 'jumlah_tersedia' => $this->jumlah_tersedia,
            'harga_sewa_perjam' => $this->harga_sewa_perjam,
            'harga_sewa_perhari' => $this->harga_sewa_perhari,
            'keterangan' => $this->keterangan,
            'kondisi' => $this->kondisi,
        ];
    }
}
