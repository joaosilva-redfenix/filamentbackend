<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'group_id',
    ];
  

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('owned', function (Builder $builder) {
            if(app()->runningInConsole()) return;
            if(!auth()->user()->is_admin){
                $builder->where('group_id', auth()->user()->group->id);
            }   
        });
    }
}