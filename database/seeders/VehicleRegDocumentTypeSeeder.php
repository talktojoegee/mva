<?php

namespace Database\Seeders;

use App\Models\VehicleRegDocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleRegDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
          "Drivers license",
          "Proof of Ownership",
          "Certificate of Roadworthiness",
          "Insurance Certificate",
          "Allocation of Registration No.",
          "Affidavit",
          "Vehicle Tax",
          "NIN",
          "International Passport",
        ];
        foreach($types as $type){
            VehicleRegDocumentType::create(["vrdt_name"=>$type]);
        }
    }
}
