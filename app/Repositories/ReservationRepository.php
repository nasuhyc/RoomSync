<?php

namespace App\Repositories;

use App\Interfaces\ReservationRepositoryInterface;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\BedStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;




class ReservationRepository implements ReservationRepositoryInterface
{

    public function getReservation()
    {
        $reservations = Reservation::with('room.bedstatus')->orderBy('room_id', 'asc')->get();
        return view('reservationPage', compact('reservations'));
    }


    public function makeReservation($datas)
    {
        $startDate = $datas['start_date'];
        $endDate = $datas['end_date'];

        if (empty($startDate) || empty($endDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please select check-in and check-out dates.'
            ]);
        }

        $guestCount = $datas['guestCount'];
        $gender = '';
        if (!empty($datas['gender'][0])) {
            $gender .= $datas['gender'][0];

            if (!empty($datas['gender'][1])) {
                $gender .= ',' . $datas['gender'][1];
            }
        } elseif (!empty($datas['gender'][0])) {
            $gender = $datas['gender'][0];
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Please select a Gender.'
            ]);
        }


        if($datas['guestCount'] == 1){

            if(empty($datas['gender'][0])){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please select a Gender.'
                ]);
            }

            if(!empty($datas['gender'][1])){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Since the number of guests is 1, please do not select the gender of the second person, or choose the number of guests as 2.'
                ]);
            }

            if(!empty($datas['type'])){
            if($datas['type'] !== 'twin'){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please choose a single room option.'
                ]);
            }else {
                $datas['type'] = 'twin';
            }
            }else {
                $datas['type'] = 'twin';
            }




            $room = Room::with('bedstatus', 'reservations')
            ->where('type', 'twin')
            ->where('capacity', 2)
            ->whereDoesntHave('reservations', function ($query) use ($datas) {
                $query->where('start_date', '<=', $datas['end_date'])
                      ->where('end_date', '>=', $datas['start_date'])
                      ->where('gender','!=',$datas['gender'][0]);
            })
            ->whereHas('bedstatus', function ($query) {
                $query->where('status', 'available');
            })
            ->first();


       }else if($datas['guestCount'] == 2){

            if(empty($datas['gender'][0]) || empty($datas['gender'][1])){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please select the genders of 2 people or choose the number of guests as 1.'
                ]);
            }



            if(!empty($datas['type']) && $datas['type'] == 'double'){
                $datas['type'] = 'double';
            }else if(!empty($datas['type']) && $datas['type'] == 'twin'){
                $datas['type'] = 'twin';
            }else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please select the room type.'
                ]);
            }

            if($datas['type'] == 'double'){
                $room = Room::with('bedstatus', 'reservations')
            ->where('type', $datas['type'])
            ->where('capacity', 2)
            ->whereDoesntHave('reservations', function ($query) use ($datas) {
                $query->where('start_date', '<=', $datas['end_date'])
                      ->where('end_date', '>=', $datas['start_date']);
            })
            ->first();
            }else {
                $room = Room::with('bedstatus', 'reservations')
                ->where('type', $datas['type'])
                ->where('capacity', 2)
                ->whereDoesntHave('reservations', function ($query) use ($datas) {
                    $query->where('start_date', '<=', $datas['end_date'])
                          ->where('end_date', '>=', $datas['start_date']);

                })->whereHas('bedstatus', function ($query) {
                    $query->where('status', 'available');
                })
                ->first();
            }




       }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Please select the number of guests.'
            ]);

        }

        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'No available rooms found.'
            ]);
        }

        $reservation = new Reservation([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'guest_count' => $guestCount,
            'gender' => $gender,
        ]);

        $room->reservations()->save($reservation);

        // Bed Status Update for Reservation
        $bedStatus = BedStatus::where('room_id', $room->id)
            ->where('status', 'available')
            ->orderBy('bed_number')
            ->get();

        if (count($bedStatus)>0) {
           if ($guestCount == 1) {
                $bedStatus[0]->status = 'unavailable';
                $bedStatus[0]->save();
            } else {
                $bedStatus[0]->status = 'unavailable';
                $bedStatus[0]->save();
                $bedStatus[1]->status = 'unavailable';
                $bedStatus[1]->save();
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Reservation successfully created.',
            'room' => $room,
            'reservation' => $reservation,
        ]);
    }
}




?>
