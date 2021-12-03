<?php

namespace App\Models;

use App\Models\House;
use App\Models\Visitor;
use Laravel\Passport\HasApiTokens;
use App\Traits\MutatePasswordAttribute;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use MutatePasswordAttribute;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function houses()
    {
        return $this->belongsToMany(House::class, 'user_houses');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
}
