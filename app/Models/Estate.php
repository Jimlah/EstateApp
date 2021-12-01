<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
