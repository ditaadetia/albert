<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenyewaanBaru extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $position)
    {
        $this->data = $data;
        $this->position = $position;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('uptd.albert.pupr.pontianak@gmail.com')
                   ->view('penyewaan_baru')
                   ->subject('Pengajuan Penyewaan ' .  $this->data->nama_kegiatan . ' ' . $this->data->id)
                   ->with(
                    [
                        'nama_instansi' => $this->data->nama_instansi,
                        'nama_kegiatan' => $this->data->nama_kegiatan,
                        'nama_penyewa' => $this->data->nama,
                        'tanggal_mulai' => $this->data->tanggal_mulai,
                        'tanggal_selesai' => $this->data->tanggal_selesai,
                        'position' => $this->position,
                    ])
                    ->attach(public_path() . '/storage' .'/dokumen_sewa/'. $this->data->dokumen_sewa, [
                        'as' => $this->data->dokumen_sewa,
                        'mime' => 'application/pdf',
                    ]);
    }
}
