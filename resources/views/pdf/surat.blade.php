<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat - {{ $pengajuan->nomor_surat }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            font-size: 12pt;
            margin: 0;
            padding: 30px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h1 {
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
        }
        .kop-surat h2 {
            font-size: 18pt;
            margin: 0;
            text-transform: uppercase;
        }
        .kop-surat p {
            font-size: 11pt;
            margin: 0;
        }
        .judul-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-surat h3 {
            margin: 0;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .judul-surat p {
            margin: 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .table-data {
            width: 100%;
            margin-left: 30px;
            margin-bottom: 20px;
        }
        .table-data td {
            vertical-align: top;
            padding: 3px 0;
        }
        .td-label {
            width: 150px;
        }
        .td-colon {
            width: 20px;
        }
        .signature-box {
            width: 300px;
            float: right;
            text-align: center;
            margin-top: 50px;
        }
        .signature-box p {
            margin: 0;
        }
        .signature-space {
            height: 80px;
        }
        /* Clearfix */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PEMERINTAH KABUPATEN BARITO KUALA</h1>
        <h2>KECAMATAN ALALAK</h2>
        <h1>DESA PANDAK DAUN</h1>
        <p>Jl. Handil Bakti, Desa Pandak Daun, Kode Pos 70582</p>
    </div>

    <div class="judul-surat">
        <h3>{{ $pengajuan->jenisSurat->nama }}</h3>
        <p>Nomor: {{ $pengajuan->nomor_surat }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Pandak Daun, Kecamatan Alalak, Kabupaten Barito Kuala, menerangkan dengan sebenarnya bahwa:</p>

        <table class="table-data">
            <tr>
                <td class="td-label">Nama Lengkap</td>
                <td class="td-colon">:</td>
                <td><strong>{{ $pengajuan->user->name }}</strong></td>
            </tr>
            <tr>
                <td class="td-label">NIK</td>
                <td class="td-colon">:</td>
                <td>{{ $pengajuan->user->nik }}</td>
            </tr>
            <tr>
                <td class="td-label">Alamat</td>
                <td class="td-colon">:</td>
                <td>{{ $pengajuan->user->address }}, RT {{ $pengajuan->user->rt ?? '-' }} / RW {{ $pengajuan->user->rw ?? '-' }}</td>
            </tr>
            <tr>
                <td class="td-label">Keperluan</td>
                <td class="td-colon">:</td>
                <td>{{ $pengajuan->keperluan }}</td>
            </tr>
            
            @if(is_array($pengajuan->data_tambahan))
                @foreach($pengajuan->data_tambahan as $key => $value)
                    @php
                        $label = $key;
                        $form_fields = is_array($pengajuan->jenisSurat->form_fields) ? $pengajuan->jenisSurat->form_fields : [];
                        foreach($form_fields as $field) {
                            if($field['name'] === $key) {
                                $label = $field['label'];
                                break;
                            }
                        }
                    @endphp
                    <tr>
                        <td class="td-label">{{ $label }}</td>
                        <td class="td-colon">:</td>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            @endif
        </table>

        <p>Orang tersebut di atas adalah benar-benar warga Desa Pandak Daun dan surat ini diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya.</p>
        <p>Demikian surat keterangan ini dibuat agar dapat dipergunakan seperlunya.</p>
    </div>

    <div class="clearfix">
        <div class="signature-box">
            <p>Pandak Daun, {{ \Carbon\Carbon::parse($pengajuan->updated_at)->locale('id')->translatedFormat('d F Y') }}</p>
            <p>Kepala Desa Pandak Daun,</p>
            <div class="signature-space">
                <!-- Tanda Tangan Elektronik placeholder -->
            </div>
            <p><strong><u>M. RIYANDI</u></strong></p>
        </div>
    </div>

</body>
</html>
