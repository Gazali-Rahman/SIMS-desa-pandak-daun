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
}
