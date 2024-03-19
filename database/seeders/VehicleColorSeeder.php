<?php

namespace Database\Seeders;

use App\Models\VehicleColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
          "White",
          "Black",
          "Gold",
          "Blue",
          "Gray",
          "Silver",
          "Red",
          "Green",
          "Brown",
          "Orange",
          "Beige",
          "Purple",
          "Yellow"
        ];
        foreach($colors as $color){
            $col = new VehicleColor();
            $col->name = $color;
            $col->save();
        }
    }
}
