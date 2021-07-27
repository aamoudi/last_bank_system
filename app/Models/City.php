<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function getStatusAttribute()
    {
        if ($this->active) {
            return "Active";
        } else {
            return "InActive";
        }
    }

    public function admins()
    {
        // return $this->hasMany(Admin::class);
        return $this->hasMany(Admin::class, 'city_id', 'id');
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
