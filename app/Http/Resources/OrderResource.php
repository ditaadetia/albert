<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'tenant_id' => $this->tenant_id,
            'category_order_id' => $this->category_order_id,
            'nama_instansi' => $this->nama_instansi,
            'jabatan' => $this->jabatan,
            'alamat_instansi' => $this->alamat_instansi,
            'nama_kegiatan' => $this->nama_kegiatan,
            'ktp' => asset('storage/' . $this->ktp),
            'surat_permohonan' => asset('storage/' . $this->surat_permohonan),
            'akta_notaris' => asset('storage/' . $this->akta_notaris),
            'surat_ket' => asset('storage/' . $this->surat_ket),
            // 'ket_verif_admin' => $this->ket_verif_admin,
            // 'ket_persetujuan_kepala_uptd' => $this->ket_persetujuan_kepala_uptd,
            // 'ket_persetujuan_kepala_dinas' => $this->ket_persetujuan_kepala_dinas,
            // 'ttd_kepala_uptd' => $this->ttd_kepala_uptd,
            // 'ttd_kepala_dinas' => $this->ttd_kepala_dinas,
            // 'ket_konfirmasi' => $this->ket_konfirmasi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            // 'dokumen_sewa' => $this->dokumen_sewa,
        ];
    }
}
