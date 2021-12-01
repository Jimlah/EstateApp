<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'estate_id',
        'manager_id',
    ];
}
