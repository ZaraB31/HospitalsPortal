<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id', 'name', 'type',
    ];

    public function board() {
        return $this->hasMany(Board::class);
    }

    public function hospital() {
        return $this->belongsTo(Hospital::class);
    }

    public function job() {
        return $this->belongsTo(Location::class);
    }

    public function schedule() {
        return $this->hasMany(Schedule::class);
    }
}
