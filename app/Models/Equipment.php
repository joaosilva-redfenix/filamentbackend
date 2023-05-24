<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = ['name'];

    protected function bla(){
        return 'tiahsd';
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}