<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelsAndRoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = Hotel::factory(10)->create();
        foreach($hotels as $hotel) {
            $i = 0;
            $rooms = 10;
            while($i < $rooms) {
                $roomNumber = fake()->numberBetween(1, 100);
                $roomName = "Quarto " . $roomNumber;
                $hotel->rooms()->create([
                    'name' => $roomName,
                    'description' => null,
                ]);
                $i++;
            }
        }
    }
}
