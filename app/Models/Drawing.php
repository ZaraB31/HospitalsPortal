<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'file', 'version', 'location_id',
    ];

    public function location() {
        return $this->belongsTo(Location::class);
    }
}
