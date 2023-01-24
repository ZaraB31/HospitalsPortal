<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remedial extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id', 'circuitNo', 'room', 'description', 'approved',
    ];

    public function remedialPhoto() {
        return $this->hasMany(RemedialPhoto::class);
    }

    public function board() {
        return $this->belongsTo(Board::class);
    }

    public function remedialPrice() {
        return $this->belongsTo(RemedialPrice::class);
    }
}
