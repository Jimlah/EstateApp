<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'estate_id',
        'description',
        'address',
        'category',
        'code'
    ];

    protected static function booted()
    {
        static::creating(function ($house) {
            $house->code = Str::random(3);
        });
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}
