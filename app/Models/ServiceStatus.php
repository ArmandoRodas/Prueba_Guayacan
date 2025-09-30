<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceStatus extends Model
{
    public $timestamps = false;
    protected $fillable = ['code', 'label'];

    public function services()
    {
        return $this->hasMany(Service::class, 'current_status_id');
    }
    public function history()
    {
        return $this->hasMany(ServiceStatusHistory::class, 'status_id');
    }
}
