<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'updated_at',
        'created_at'
    ];
    public function detail(){
        return $this->hasMany(DetailPenjualan::class);
    }
    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class);
    }
}
