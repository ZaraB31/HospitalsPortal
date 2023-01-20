<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id', 'user_id',
    ];

    public function test() {
        return $this->belongTo(Test::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
