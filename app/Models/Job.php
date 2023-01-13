<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'start', 'finish', 'location_id', 'details', 'approved', 'completed',
    ];

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function UserJob() {
        return $this->belongsTo(UserJob::class);
    }
}
