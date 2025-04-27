<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';

    use HasFactory;

    protected $fillable = [
        'barang_id',
        'quantity',
        'no_barang_masuk',
        'tanggal_masuk',
        'origin',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
