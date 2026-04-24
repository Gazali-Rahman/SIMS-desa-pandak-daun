<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Anda Telah Disetujui</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9fafb; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #e5e7eb; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { color: #4f46e5; margin: 0; font-size: 24px; }
        .content p { margin: 0 0 15px; }
        .details { background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
        .details strong { display: inline-block; width: 120px; }
        .btn { display: inline-block; background-color: #4f46e5; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; margin-top: 10px; }
        .footer { margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 20px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SIMS Desa Pandak Daun</h1>
        </div>
        
        <div class="content">
            <p>Halo, <strong>{{ $pengajuan->user->name }}</strong>!</p>
            <p>Kabar baik! Pengajuan surat Anda telah disetujui dan ditandatangani oleh Kepala Desa.</p>
            
            <div class="details">
                <p><strong>Jenis Surat</strong> : {{ $pengajuan->jenisSurat->nama }}</p>
                <p><strong>Nomor Surat</strong> : {{ $pengajuan->nomor_surat }}</p>
                <p><strong>Tanggal ACC</strong> : {{ $pengajuan->updated_at->format('d F Y') }}</p>
            </div>
            
            <p>Surat Anda kini sudah berstatus <strong>Selesai</strong>. Anda dapat langsung mengunduh dan mencetak file PDF surat tersebut melalui panel akun Anda.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('warga.dashboard') }}" class="btn" style="color: #ffffff;">Lihat Riwayat Pengajuan</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh Sistem Informasi Manajemen Surat (SIMS) Desa Pandak Daun.</p>
            <p>Harap tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
