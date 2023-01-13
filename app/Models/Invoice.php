<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id', 'invoiceNo', 'sentDate', 'paid',
    ];

    public function Test() {
        return $this->belongsTo(Test::class);
    }
}
