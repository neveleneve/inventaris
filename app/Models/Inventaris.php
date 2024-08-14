<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model {
    use HasFactory;

    protected $fillable = [
        'kode_inventarisasi',
        'jenis_inventarisasi',
        'tahun_pengadaan',
        'verified_at',
    ];

    public function aset() {
        return $this->hasMany(Item::class);
    }

    public function inventaris_keluar() {
        return $this->hasMany(InventarisKeluar::class);
    }
}
