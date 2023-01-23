<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id', 'name', 'file', 'circuits', 'result',
    ];

    public function invoice() {
        return $this->hasOne(Invoice::class);
    }

    public function board() {
        return $this->belongsTo(Board::class);
    }
    
    public function download() {
        return $this->belongTo(Download::class);
    }
}
