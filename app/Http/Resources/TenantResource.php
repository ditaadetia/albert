<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
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
            'nama' => $this->nama,
            'foto' => $this->foto,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'no_hp' => $this->no_hp,
            'kontak_darurat' => $this->kontak_darurat,
            'alamat' => $this->alamat,
        ];
    }
}
