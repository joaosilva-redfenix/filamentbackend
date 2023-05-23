<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }
}