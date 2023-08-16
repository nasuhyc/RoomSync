<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use App\Models\BedStatus;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'capacity'];


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function bedstatus()
    {
        return $this->hasMany(BedStatus::class);
    }
}
