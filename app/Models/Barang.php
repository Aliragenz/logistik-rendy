<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kode_barang',
    ];
}
