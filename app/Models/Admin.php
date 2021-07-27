<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasRoles, Notifiable, HasApiTokens;

    public function getGenderTitleAttribute()
    {
        return $this->gender == 'M' ? 'Male' : 'Female';
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    /**
     * TO Create a Relation
     * 1) Create new function with suitable name represent relation data
     * NOTES:
     *      1) DO NOT MISS RETURN
     *      2) USE $this (City)
     *      3) Define relation type
     *      4) Defin relation properties
     */
}
