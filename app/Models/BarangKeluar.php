<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    use HasFactory;

    protected $fillable = [
        'barang_id',
        'quantity',
        'no_barang_keluar',
        'tanggal_keluar',
        'destination',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
