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
}
