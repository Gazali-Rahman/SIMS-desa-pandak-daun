<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Pelayanan Administrasi</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 12px; line-height: 1.5; color: #000; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1, .kop-surat h2, .kop-surat h3 { margin: 0; padding: 0; }
        .kop-surat h1 { font-size: 18px; text-transform: uppercase; }
        .kop-surat h2 { font-size: 22px; text-transform: uppercase; font-weight: bold; }
        .kop-surat p { font-size: 12px; margin-top: 5px; }
        .title { text-align: center; margin-bottom: 20px; }
        .title h3 { text-decoration: underline; margin: 0; font-size: 14px; }
        .title p { margin: 5px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .signature { width: 300px; float: right; text-align: center; margin-top: 30px; }
        .signature p { margin: 0; }
        .signature .name { font-weight: bold; text-decoration: underline; margin-top: 70px; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h1>PEMERINTAH KABUPATEN BANJAR</h1>
        <h2>KECAMATAN KARANG INTAN</h2>
        <h2>PEMERINTAH DESA PANDAK DAUN</h2>
        <p>Jl. Melati RT. 01 RW. 01 Desa Pandak Daun Kecamatan Karang Intan Kode Pos 70661</p>
    </div>

    <div class="title">
        <h3>LAPORAN REKAPITULASI PELAYANAN ADMINISTRASI SURAT</h3>
        <p>
            Periode: 
            {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '-' }} s.d 
            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '-' }}
        </p>
    </div>

    <div style="margin-bottom: 10px;">
        <p style="margin: 0;"><strong>Ringkasan:</strong></p>
        <table style="width: 50%; margin-top: 5px; border: none;">
            <tr style="border: none;"><td style="border: none; padding: 2px;">Total Pengajuan</td><td style="border: none; padding: 2px;">: {{ $stats['total'] }}</td></tr>
            <tr style="border: none;"><td style="border: none; padding: 2px;">Disetujui (Selesai)</td><td style="border: none; padding: 2px;">: {{ $stats['disetujui'] }}</td></tr>
            <tr style="border: none;"><td style="border: none; padding: 2px;">Ditolak</td><td style="border: none; padding: 2px;">: {{ $stats['ditolak'] }}</td></tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Nama Pemohon</th>
                <th width="15%">NIK</th>
                <th width="25%">Jenis Surat</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->user->name }}</td>
                <td class="text-center">{{ $item->user->nik }}</td>
                <td>{{ $item->jenisSurat->nama }}</td>
                <td class="text-center">{{ ucfirst($item->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data pengajuan dalam periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature">
        <p>Pandak Daun, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        <p>Kepala Desa Pandak Daun</p>
        <div class="name">SARBANI</div>
    </div>
</body> 
</html>
