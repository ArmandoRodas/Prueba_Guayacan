<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'phone', 'role', 'is_active'];

    public function assignedServices()
    {
        return $this->hasMany(Service::class, 'assigned_tech_id');
    }
    public function statusChanges()
    {
        return $this->hasMany(ServiceStatusHistory::class, 'changed_by_id');
    }
}
