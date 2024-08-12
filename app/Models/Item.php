<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'jenis_id',
        'inventaris_id',
        'id_item',
    ];

    public function inventaris() {
        return $this->belongsTo(Inventaris::class);
    }

    public function jenis() {
        return $this->belongsTo(JenisAset::class);
    }
}
