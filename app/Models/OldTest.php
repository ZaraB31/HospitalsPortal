<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id', 'name', 'file',
    ];

    public function board() {
        return $this->belongsTo(Board::class);
    }
}
