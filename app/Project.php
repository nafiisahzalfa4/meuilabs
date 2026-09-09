<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Orders;

class Project extends Model
{

    protected $fillable = [
        'order_id',
        'project_name',
        'start_date',
        'deadline',
        'progress',
        'status',
    ]; 

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
        'progress' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
