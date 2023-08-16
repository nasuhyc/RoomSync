<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ReservationRepositoryInterface;

class ReservationController extends Controller
{

    private ReservationRepositoryInterface $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function makeReservation(Request $request){
        $datas = $request->all();
        return $this->reservationRepository->makeReservation($datas);
    }

    public function getReservation(){
        return $this->reservationRepository->getReservation();
    }

}
