<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanKTP extends Model
{
    use HasFactory;
    protected $table = 'ktp';


    protected $fillable = [
        'nama',
        'nik',
        'alamat',

    ];
}
