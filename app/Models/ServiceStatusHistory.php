<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceStatusHistory extends Model
{
    public $timestamps = false; // solo created_at
    protected $fillable = ['service_id', 'status_id', 'changed_by_id', 'comment', 'created_at'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function status()
    {
        return $this->belongsTo(ServiceStatus::class, 'status_id');
    }
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by_id');
    }
}
