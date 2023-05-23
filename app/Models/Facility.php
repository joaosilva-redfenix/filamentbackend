<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location'
    ];
  

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
