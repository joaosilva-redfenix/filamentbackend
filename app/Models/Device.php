<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'consumption',
        'group_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
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