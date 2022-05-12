<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reschedule extends Mailable
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
                   ->view('reschedule_notif')
                   ->subject('Pengajuan Perubahan Jadwal ' .  $this->data->nama_kegiatan . ' ' . $this->data->id)
                   ->with(
                    [
                        'nama_instansi' => $this->data->nama_instansi,
                        'nama_kegiatan' => $this->data->nama_kegiatan,
                        'nama_penyewa' => $this->data->nama,
                        'tanggal_mulai' => $this->data->tanggal_mulai,
                        'tanggal_selesai' => $this->data->tanggal_selesai,
                        'waktu_mulai' => $this->data->waktu_mulai,
                        'waktu_selesai' => $this->data->waktu_selesai,
                    ]);
    }
}
