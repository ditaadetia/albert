<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class pemberitahuanPembatalan extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('uptd.albert.pupr.pontianak@gmail.com')
        ->view('pemberitahuan_pembatalan')
        ->subject('Pembatalan ' .  $this->data->nama_kegiatan . ' ' . $this->data->id)
        ->with(
         [
             'nama_instansi' => $this->data->nama_instansi,
             'nama_kegiatan' => $this->data->nama_kegiatan,
             'nama_penyewa' => $this->data->nama,
             'nama_alat' => $this->data->nama_alat,
         ]);
    }
}
