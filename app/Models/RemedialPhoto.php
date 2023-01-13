<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemedialPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'remedial_id', 'name', 'file',
    ];

    public function remedial() {
        return $this->belongsTo(Remedial::class);
    }
}
