<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date', 'guest_count', 'gender', 'room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
