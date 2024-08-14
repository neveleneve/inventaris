<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisKeluar extends Model {
    use HasFactory;

    protected $fillable = [
        'item_id',
        'inventaris_id',
        'keterangan',
    ];

    public function aset() {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function inventaris() {
        return $this->belongsTo(Inventaris::class);
    }
}
