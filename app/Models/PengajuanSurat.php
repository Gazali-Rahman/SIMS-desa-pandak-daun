<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    protected $fillable = [
        'nomor_surat',
        'user_id',
        'jenis_surat_id',
        'keperluan',
        'data_tambahan',
        'dokumen_syarat',
        'status',
        'catatan',
        'file_surat_url'
    ];

    protected $casts = [
        'data_tambahan' => 'array',
        'dokumen_syarat' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function generateNomorSuratAndApprove()
    {
        return \Illuminate\Support\Facades\DB::transaction(function () {
            // Lock the parent record first to prevent race condition
            $jenisSurat = $this->jenisSurat()->lockForUpdate()->first();

            $count = self::where('jenis_surat_id', $this->jenis_surat_id)
                ->where('status', 'selesai')
                ->whereYear('created_at', date('Y'))
                ->count() + 1;

            $kode = $jenisSurat->kode ?? 'SRT';
            $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);
            
            $map = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
            $romawiBulan = $map[date('n')];
            $tahun = date('Y');

            $nomorSurat = "140/$urutan/$kode/$romawiBulan/$tahun";

            $this->update([
                'status' => 'selesai',
                'nomor_surat' => $nomorSurat,
            ]);

            return $nomorSurat;
        });
    }
}
