<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'designer_id',
        'service_id',
        'tanggal_pesan',
        'catatan',
        'total_harga',
        'status',
    ];

    protected $casts = [
        'tanggal_pesan' => 'date',
        'total_harga' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function project()
    {
        return $this->hasOne(Project::class);
    }
}
