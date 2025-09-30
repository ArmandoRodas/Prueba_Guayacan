<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['first_name', 'last_name', 'tax_id', 'phone', 'email', 'address'];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
