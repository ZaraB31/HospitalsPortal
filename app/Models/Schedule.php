<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id', 'start', 'end', 'approved', 'completed',
    ];

    public function Location() {
        return $this->belongsTo(Location::class);
    }
}
