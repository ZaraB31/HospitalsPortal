<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemedialPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'remedial_id', 'price_id',
    ];

    public function remedial() {
        return $this->belongsTo(Remedial::class);
    }

    public function price() {
        return $this->belongsTo(Price::class);
    }
}
