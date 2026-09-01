<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $table = 'portfolios';

    protected $fillable = [
        'designer_id',
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
    ];

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }
}