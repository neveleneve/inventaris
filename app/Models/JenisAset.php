<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAset extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function aset() {
        return $this->hasMany(Item::class);
    }
}
