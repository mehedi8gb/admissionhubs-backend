<?php

namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'University of Lagos',
            'University of Ibadan',
            'University of Benin',
            'University of Port Harcourt',
            'University of Abuja',
            'University of Calabar',
            'University of Jos',
            'University of Ilorin',
            'University of Maiduguri',
            'University of Uyo',
            'University of Nigeria',
            'University of Zaria',
            'University of Sokoto',
            'University of Kano',
            'University of Kaduna',
            'University of Owerri',
            'University of Enugu',
            'University of Awka',
            'University of Nsukka',
            'University of Abakaliki',
            'University of Makurdi',
            'University of Lafia',
            'University of Minna',
            'University of Keffi',
            'University of Otukpo',
            'University of Okene',
            'University of Lokoja',
            'University of Kabba',
            'University of Omu-Aran',
            'University of Offa',
            'University of Iwo',
        ];

        foreach ($names as $name) {
            Institute::factory()->create(['name' => $name]);
        }
    }
}
