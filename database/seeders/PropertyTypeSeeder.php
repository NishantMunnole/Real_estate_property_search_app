<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('property_types')->insert([
            ['name' => 'Apartment'],
            ['name' => 'Villa'],
            ['name' => 'Independent House'],
            ['name' => 'Studio Apartment'],
            ['name' => 'Penthouse'],
            ['name' => 'Duplex'],
            ['name' => 'Farm House'],
            ['name' => 'Commercial Office'],
            ['name' => 'Shop'],
            ['name' => 'Warehouse'],
            ['name' => 'Co-working Space'],
            ['name' => 'PG / Hostel'],
            ['name' => 'Residential Plot'],
            ['name' => 'Commercial Plot'],
            ['name' => 'Industrial Land'],
        ]);
    }
}
