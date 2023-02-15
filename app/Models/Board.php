<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id', 'name',
    ];

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function test() {
        return $this->hasOne(Test::class);
    }

    public function oldTest() {
        return $this->hasMany(Test::class);
    }

    public function remedial() {
        return $this->belongsTo(Remedial::class);
    }
}
