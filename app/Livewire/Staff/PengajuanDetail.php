<?php

namespace App\Livewire\Staff;

use App\Models\PengajuanSurat;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Detail Pengajuan - APLIKASI PELAYANAN ADMINISTRASI PENDUDUK DESA PANDAK DAUN BERBASIS WEB',
    'header' => 'Verifikasi Berkas Pengajuan',
    'sidebar' => 'components.sidebar.main'
])]
class PengajuanDetail extends Component
{
    public PengajuanSurat $pengajuan;

    public string $status;
    public string $catatan = '';

    public function mount(PengajuanSurat $pengajuan)
    {
        $this->pengajuan = $pengajuan->load(['user', 'jenisSurat']);
        $this->status = $this->pengajuan->status;
        $this->catatan = $this->pengajuan->catatan ?? '';
    }

    public function updateStatus()
    {
        $this->validate([
            'status' => 'required|in:menunggu,diproses,ditolak',
            'catatan' => 'required_if:status,ditolak',
        ]);

        $this->pengajuan->update([
            'status' => $this->status,
            'catatan' => $this->status === 'ditolak' ? $this->catatan : null,
        ]);

        // Telegram Actionable Notification if Status is 'diproses'
        if ($this->status === 'diproses') {
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $adminChatId = env('TELEGRAM_ADMIN_CHAT_ID');
            if (!empty($botToken) && !empty($adminChatId)) {
                $jenisSurat = $this->pengajuan->jenisSurat->nama ?? 'Surat';
                $namaWarga = $this->pengajuan->user->name;
                $text = "📝 *Persetujuan Surat Diperlukan*\n\n"
                      . "Berkas pengajuan dari *$namaWarga* untuk *$jenisSurat* telah diperiksa oleh Staff dan dinyatakan lengkap.\n"
                      . "Menunggu persetujuan/stempel Kades.\n\n"
                      . "Silakan klik tombol di bawah untuk menyetujui atau menolak.";

                \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $adminChatId,
                    'text' => $text,
                    'parse_mode' => 'Markdown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => '✅ Setujui & Stempel', 'callback_data' => 'approve_' . $this->pengajuan->id],
                                ['text' => '❌ Tolak', 'callback_data' => 'reject_' . $this->pengajuan->id]
                            ]
                        ]
                    ])
                ]);
            }
        }

        $this->pengajuan->user->notify(new \App\Notifications\StatusPengajuanNotification($this->pengajuan));

        session()->flash('message', 'Status pengajuan berhasil diperbarui.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.staff.pengajuan-detail');
    }
}
