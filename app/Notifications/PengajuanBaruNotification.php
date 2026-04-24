<?php

namespace App\Notifications;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanBaruNotification extends Notification
{
    use Queueable;

    public $pengajuan;

    /**
     * Create a new notification instance.
     */
    public function __construct(PengajuanSurat $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $url = $notifiable->hasRole('kepala_desa')
            ? route('kades.persetujuan.index')
            : route('pengajuan.show', $this->pengajuan->id);

        return [
            'pengajuan_id' => $this->pengajuan->id,
            'title' => 'Pengajuan Surat Baru',
            'message' => $this->pengajuan->user->name . ' mengajukan ' . $this->pengajuan->jenisSurat->nama,
            'url' => $url,
            'icon' => 'document-text',
            'color' => 'indigo'
        ];
    }
}
