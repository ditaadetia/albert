<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Tolak extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $status, $alasan)
    {
        $this->data = $data;
        $this->status = $status;
        $this->alasan = $alasan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('uptd.albert.pupr.pontianak@gmail.com')
                   ->view('penolakan')
                   ->subject('Pengajuan Anda ditolak')
                   ->with(
                    [
                        'nama_instansi' => $this->data->nama_instansi,
                        'nama_kegiatan' => $this->data->nama_kegiatan,
                        'nama_penyewa' => $this->data->nama,
                        'tanggal_mulai' => $this->data->tanggal_mulai,
                        'tanggal_selesai' => $this->data->tanggal_selesai,
                        // 'waktu_mulai' => $this->data->waktu_mulai,
                        // 'waktu_selesai' => $this->data->waktu_selesai,
                        'waktu' => $this->data,
                        'status' => $this->status,
                        'alasan' => $this->alasan,
                    ]);
    }
}
