<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'defect', 'price',
    ];

    public function remedialPrice() {
        return $this->belongsTo(RemedialPrice::class);
    }

}
