<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'logo',
        'code',
    ];

    public function managers()
    {
        return $this->belongsToMany(Manager::class, 'estate_managers', 'estate_id', 'manager_id');
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }
}
