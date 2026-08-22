<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    /**
     * Handle the incoming Telegram webhook request.
     */
    public function handle(Request $request)
    {
        // 1. Ekstrak data dari Telegram Webhook
        $update = $request->all();

        // Handle Callback Query (tombol inline)
        if (isset($update['callback_query'])) {
            return $this->handleCallback($update['callback_query']);
        }

        // Pastikan ini pesan teks biasa
        if (!isset($update['message']['text'])) {
            return response()->json(['status' => 'success']); // Hiraukan tipe update lain
        }

        $chatId = $update['message']['chat']['id'];
        $text = $update['message']['text'];

        // 2. Jika command /start
        if ($text === '/start') {
            $this->sendMessage($chatId, "Halo! Saya adalah Agent AI Sistem Informasi Manajemen Surat (SIMS) Desa Pandak Daun. Ada yang bisa saya bantu terkait informasi surat menyurat dan data warga?");
            return response()->json(['status' => 'success']);
        }

        // 3. Teruskan ke AI
        try {
            $aiResponse = $this->askAI($text);

            // Hapus blok <think>...</think> (Monolog internal dari model tipe Reasoning seperti Qwen/DeepSeek)
            $cleanText = preg_replace('/<think>.*?<\/think>/s', '', $aiResponse['text']);
            $cleanText = trim($cleanText);

            // Format pesan dengan watermark
            $replyText = $cleanText . "\n\n_🤖 Dijawab oleh " . $aiResponse['model'] . " (" . ucfirst($aiResponse['provider']) . ")_";

            // 4. Kirim balik balasan ke Telegram
            $this->sendMessage($chatId, $replyText);
        } catch (\Exception $e) {
            Log::error("Telegram/AI Error: " . $e->getMessage());
            $this->sendMessage($chatId, "Maaf, sistem AI sedang mengalami gangguan saat ini.");
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Kirim chat ke AI (Mencoba Groq terlebih dahulu, lalu fallback ke Gemini).
     */
    private function askAI($message)
    {
        // --- INJEKSI KONTEKS DATA (BUSINESS SNAPSHOT SIMS DESA PANDAK DAUN) ---
        // 1. Data Warga (Pengguna)
        $totalUsers = \App\Models\User::count();

        // 2. Data Pengajuan Surat
        $pengajuan = \App\Models\PengajuanSurat::all();
        $totalPengajuan = $pengajuan->count();
        $selesaiPengajuan = $pengajuan->where('status', 'selesai')->count();
        $ditolakPengajuan = $pengajuan->where('status', 'ditolak')->count();
        $diprosesPengajuan = $pengajuan->whereIn('status', ['menunggu', 'diproses'])->count();

        // 3. Data Jenis Surat
        $jenisSurat = \App\Models\JenisSurat::where('is_active', 1)->get();
        $jenisSuratInfo = "";
        foreach ($jenisSurat as $js) {
            $count = $pengajuan->where('jenis_surat_id', $js->id)->count();
            $jenisSuratInfo .= "- {$js->nama} (Kode: {$js->kode}) | Total Diajukan: {$count} kali\n";
        }

        // 4. Merangkai Laporan (Dashboard Snapshot)
        $snapshot = "DATA SISTEM DESA PANDAK DAUN SAAT INI:\n"
            . "Total Warga Terdaftar (Pengguna Sistem): {$totalUsers}\n"
            . "Total Pengajuan Surat Keseluruhan: {$totalPengajuan} (Selesai: {$selesaiPengajuan}, Sedang Diproses/Menunggu: {$diprosesPengajuan}, Ditolak: {$ditolakPengajuan})\n\n"
            . "Rincian Layanan Surat (Aktif):\n" . $jenisSuratInfo;

        // 5. System Prompt Sang Analis/Asisten Kades
        $systemPrompt = "Anda adalah 'Asisten SIMS', Penasihat Data dan Asisten AI untuk Sistem Informasi Manajemen Surat (SIMS) Desa Pandak Daun. "
            . "Berikut adalah Data Sistem Desa saat ini:\n\n"
            . $snapshot . "\n\n"
            . "ATURAN SUPER PENTING: "
            . "1. Jawablah SECUKUPNYA saja sesuai pertanyaan. Jika user hanya menanyakan angka tertentu (misal: 'Berapa warga?'), jawablah singkat dan langsung ke inti (contoh: 'Jumlah warga terdaftar saat ini adalah 3'). "
            . "2. JANGAN pernah memberikan analisis panjang lebar, tabel, insight, atau saran strategi KECUALI pengguna secara eksplisit memintanya (misal: 'Tolong berikan analisa' atau 'Apa saranmu?'). "
            . "3. Gunakan gaya bahasa profesional, sopan, layaknya asisten administrasi desa yang ramah.";

        // --- DAFTAR ANTRIAN AI (Groq -> Gemini) ---
        $aiQueue = [
            // Kasta Utama: GROQ (Sangat cepat)
            ['provider' => 'groq', 'model' => 'qwen/qwen3.6-27b'],
            ['provider' => 'groq', 'model' => 'openai/gpt-oss-120b'],
            ['provider' => 'groq', 'model' => 'openai/gpt-oss-20b'],
            ['provider' => 'groq', 'model' => 'llama-3.3-70b-versatile'], // added standard valid groq model as fallback
            ['provider' => 'groq', 'model' => 'mixtral-8x7b-32768'],

            // Ban Serep: GEMINI
            ['provider' => 'gemini', 'model' => 'gemini-3.7-flash'],
            ['provider' => 'gemini', 'model' => 'gemini-3.6-flash'],
            ['provider' => 'gemini', 'model' => 'gemini-3.5-flash'],
            ['provider' => 'gemini', 'model' => 'gemini-3.5-flash-lite'],
            ['provider' => 'gemini', 'model' => 'gemini-1.5-flash'], // valid gemini model as fallback
        ];

        $groqKey = env('GROQ_API_KEY');
        $geminiKey = env('GEMINI_API_KEY');

        foreach ($aiQueue as $ai) {
            $provider = $ai['provider'];
            $modelName = $ai['model'];

            // Jika API Key tidak ada, lewati provider ini
            if ($provider === 'groq' && empty($groqKey)) continue;
            if ($provider === 'gemini' && empty($geminiKey)) continue;

            if ($provider === 'groq') {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $groqKey,
                    'Content-Type' => 'application/json'
                ])->timeout(20)->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => $modelName,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $message]
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'text' => $data['choices'][0]['message']['content'] ?? "Maaf, saya tidak mengerti respons dari Groq.",
                        'provider' => 'groq',
                        'model' => $modelName
                    ];
                }
            } else if ($provider === 'gemini') {
                $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $modelName . ':generateContent?key=' . $geminiKey;

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])->timeout(20)->post($url, [
                    'system_instruction' => [
                        'parts' => [['text' => $systemPrompt]]
                    ],
                    'contents' => [
                        ['role' => 'user', 'parts' => [['text' => $message]]]
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'text' => $data['candidates'][0]['content']['parts'][0]['text'] ?? "Maaf, saya tidak mengerti respons dari Gemini.",
                        'provider' => 'gemini',
                        'model' => $modelName
                    ];
                }
            }
        }

        // Jika semua gagal
        throw new \Exception("Semua model Groq & Gemini gagal diakses atau API Key belum diset.");
    }

    /**
     * Kirim pesan ke API Telegram.
     */
    private function sendMessage($chatId, $text)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        if (empty($botToken)) {
            Log::error("TELEGRAM_BOT_TOKEN is not set in .env");
            return;
        }
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown' // Memungkinkan format bold/italic dari Markdown AI
        ]);
    }

    /**
     * Helper route untuk set Webhook dengan mudah via browser
     */
    public function setWebhook(Request $request)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        if (empty($botToken)) {
            return response()->json(['error' => 'TELEGRAM_BOT_TOKEN belum diset di .env'], 400);
        }

        // Telegram mensyaratkan HTTPS. Kita paksa menggunakan https://
        $host = $request->getHost();
        $webhookUrl = 'https://' . $host . '/webhook/telegram';
        
        // Jika testing lokal pakai ngrok
        if ($request->has('url')) {
            $webhookUrl = $request->get('url');
        }

        $url = "https://api.telegram.org/bot{$botToken}/setWebhook?url=" . urlencode($webhookUrl);

        $response = Http::get($url);

        return response()->json([
            'webhook_url' => $webhookUrl,
            'telegram_response' => $response->json()
        ]);
    }

    /**
     * Handle Inline Keyboard Callback (Approve/Reject)
     */
    private function handleCallback($callbackQuery)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $callbackId = $callbackQuery['id'];
        $data = $callbackQuery['data'];
        $chatId = $callbackQuery['message']['chat']['id'];
        $messageId = $callbackQuery['message']['message_id'];

        $parts = explode('_', $data);
        $action = $parts[0]; // approve atau reject
        $pengajuanId = $parts[1] ?? null;

        if (!$pengajuanId) {
            $this->answerCallbackQuery($botToken, $callbackId, 'ID Pengajuan tidak valid');
            return response()->json(['status' => 'success']);
        }

        $pengajuan = \App\Models\PengajuanSurat::find($pengajuanId);

        if (!$pengajuan) {
            $this->answerCallbackQuery($botToken, $callbackId, 'Data pengajuan tidak ditemukan');
            return response()->json(['status' => 'success']);
        }

        // Pastikan statusnya masih diproses
        if ($pengajuan->status !== 'diproses') {
            $this->answerCallbackQuery($botToken, $callbackId, 'Pengajuan ini sudah tidak dalam status diproses');
            $this->editMessageText($botToken, $chatId, $messageId, "⚠️ *Aksi Dibatalkan*\nStatus pengajuan ini sudah berubah (sekarang: {$pengajuan->status}).");
            return response()->json(['status' => 'success']);
        }

        if ($action === 'approve') {
            // Proses Setuju
            $pengajuan->generateNomorSuratAndApprove();

            // Kirim Email
            try {
                \Illuminate\Support\Facades\Mail::to($pengajuan->user->email)->send(new \App\Mail\SuratSelesaiMail($pengajuan));
            } catch (\Exception $e) {
                Log::error('Failed to send approval email via Telegram: ' . $e->getMessage());
            }
            $pengajuan->user->notify(new \App\Notifications\StatusPengajuanNotification($pengajuan));

            $this->answerCallbackQuery($botToken, $callbackId, 'Surat Berhasil Disetujui!');
            $this->editMessageText($botToken, $chatId, $messageId, "✅ *Surat Disetujui*\n\nPengajuan atas nama *{$pengajuan->user->name}* telah berhasil disetujui dan nomor surat telah di-generate.");
        } elseif ($action === 'reject') {
            // Proses Tolak
            $pengajuan->update([
                'status' => 'ditolak',
                'catatan' => 'Ditolak oleh Kepala Desa via Telegram',
            ]);
            $pengajuan->user->notify(new \App\Notifications\StatusPengajuanNotification($pengajuan));

            $this->answerCallbackQuery($botToken, $callbackId, 'Surat Ditolak');
            $this->editMessageText($botToken, $chatId, $messageId, "❌ *Surat Ditolak*\n\nPengajuan atas nama *{$pengajuan->user->name}* telah ditolak via Telegram.");
        }

        return response()->json(['status' => 'success']);
    }

    private function answerCallbackQuery($botToken, $callbackQueryId, $text)
    {
        Http::post("https://api.telegram.org/bot{$botToken}/answerCallbackQuery", [
            'callback_query_id' => $callbackQueryId,
            'text' => $text,
            'show_alert' => false
        ]);
    }

    private function editMessageText($botToken, $chatId, $messageId, $text)
    {
        Http::post("https://api.telegram.org/bot{$botToken}/editMessageText", [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'parse_mode' => 'Markdown'
        ]);
    }
}
