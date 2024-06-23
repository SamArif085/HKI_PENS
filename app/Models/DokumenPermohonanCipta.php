<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPermohonanCipta extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pc';
        protected $fillable = [
        'nama_pencipta',
        'wn_pencipta',
        'alamat_pencipta',
        'email_pencipta',
        'no_hp_pencipta',
        'nama_pg_hak',
        'wn_pg_hak',
        'alamat_pg_hak',
        'email_pg_hak',
        'jenis_cipta',
        'tgl_tempat',
        'uraian_cipta',
    ];
}
