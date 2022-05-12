<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifRefund extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $total_bayar, $position)
    {
        $this->data = $data;
        $this->total_bayar = $total_bayar;
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
                   ->view('refund_notif')
                   ->subject('Pengajuan Pengembalian Dana ' .  $this->data->nama_kegiatan . ' ' . $this->data->id)
                   ->with(
                    [
                        'nama_instansi' => $this->data->nama_instansi,
                        'nama_kegiatan' => $this->data->nama_kegiatan,
                        'nama_penyewa' => $this->data->nama,
                        'tanggal_mulai' => $this->data->tanggal_mulai,
                        'tanggal_selesai' => $this->data->tanggal_selesai,
                        'total_bayar' => $this->total_bayar,
                        'position' => $this->position,
                    ])
                    ->attach(public_path() . '/storage' .'/'. $this->data->bukti_refund, [
                        'as' => $this->data->bukti_refund,
                        'mime' => 'image/*, application/pdf',
                    ]);
    }
}
