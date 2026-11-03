<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'nama_jasa',
        'deskripsi',
        'harga',
        'gambar',
        'status',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}