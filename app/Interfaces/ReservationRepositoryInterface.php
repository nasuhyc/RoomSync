<?php

namespace App\Interfaces;

interface ReservationRepositoryInterface
{
    public function makeReservation($datas);
    public function getReservation();
}


?>
