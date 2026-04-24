<?php

namespace App\Notifications;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusPengajuanNotification extends Notification
{
    use Queueable;

    public $pengajuan;
    public $status_message;
    public $color;

    /**
     * Create a new notification instance.
     */
    public function __construct(PengajuanSurat $pengajuan)
    {
        $this->pengajuan = $pengajuan;
        
        switch ($pengajuan->status) {
            case 'diproses':
                $this->status_message = 'Pengajuan Anda sedang diproses oleh Staff.';
                $this->color = 'blue';
                break;
            case 'selesai':
                $this->status_message = 'Pengajuan Anda telah disetujui oleh Kades.';
                $this->color = 'green';
                break;
            case 'ditolak':
                $this->status_message = 'Pengajuan Anda ditolak.';
                $this->color = 'red';
                break;
            default:
                $this->status_message = 'Status pengajuan Anda diperbarui.';
                $this->color = 'slate';
                break;
        }
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
        return [
            'pengajuan_id' => $this->pengajuan->id,
            'title' => 'Status Pengajuan Diperbarui',
            'message' => $this->status_message,
            'url' => route('warga.pengajuan.index'),
            'icon' => 'information-circle',
            'color' => $this->color
        ];
    }
}
