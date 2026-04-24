<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'icon',
        'syarat',
        'form_fields',
        'is_active'
    ];

    protected $casts = [
        'syarat' => 'array',
        'form_fields' => 'array',
        'is_active' => 'boolean',
    ];

    public function pengajuanSurats()
    {
        return $this->hasMany(PengajuanSurat::class);
    }
}
