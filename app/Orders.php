<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Project;
use App\Service;

class Orders extends Model
{
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
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'order_id');
    }
}