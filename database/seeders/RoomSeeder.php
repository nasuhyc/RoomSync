<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\BedStatus;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Double yataklı odalar
        for ($i = 1; $i <= 5; $i++) {
            Room::create([
                'type' => 'double',
                'capacity' => 2,
            ]);
        }

        // Twin yataklı odalar
        for ($i = 1; $i <= 5; $i++) {
            $room = Room::create([
                'type' => 'twin',
                'capacity' => 2,
            ]);

            // Twin yatakların bed_statuses kayıtları
            for ($j = 1; $j <= 2; $j++) {
                BedStatus::create([
                    'room_id' => $room->id,
                    'bed_number' => $j,
                    'status' => 'available', // available, unavailable
                ]);
            }
        }
    }

}
