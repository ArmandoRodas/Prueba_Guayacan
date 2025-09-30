<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'folio',
        'client_id',
        'device_id',
        'received_at',
        'reported_issue',
        'diagnosis',
        'solution',
        'current_status_id',
        'assigned_tech_id',
    ];

    // Relaciones (por si aún no las tenías)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function status()
    {
        return $this->belongsTo(ServiceStatus::class, 'current_status_id');
    }
    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_tech_id');
    }
    public function history()
    {
        return $this->hasMany(ServiceStatusHistory::class);
    }
}
