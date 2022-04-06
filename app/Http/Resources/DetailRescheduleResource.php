<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailRescheduleResource extends JsonResource
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
            'detail_order_id' => $this->order_id,
            'order_id' => $this->order_id,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'ket_verif_admin' =>$this->ket_verif_admin,
            'ket_persetujuan_kepala_uptd' =>$this->ket_persetujuan_kepala_uptd,
            'keterangan' =>$this->keterangan,
            // 'tanggal_ambil' => $this->tanggal_ambil,
            // 'tanggal_kembali' => $this->tanggal_kembali,
            // 'status' => $this->status,
        ];
    }
}
