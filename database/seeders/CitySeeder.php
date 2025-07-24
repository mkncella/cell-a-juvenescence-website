<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        // Daftar ibukota berdasarkan nama provinsi
        $provinceCapitals = [
            'Aceh' => 'Banda Aceh',
            'Sumatera Utara' => 'Medan',
            'Sumatera Barat' => 'Padang',
            'Riau' => 'Pekanbaru',
            'Kepulauan Riau' => 'Tanjung Pinang',
            'Jambi' => 'Jambi',
            'Sumatera Selatan' => 'Palembang',
            'Bangka Belitung' => 'Pangkal Pinang',
            'Bengkulu' => 'Bengkulu',
            'Lampung' => 'Bandar Lampung',
            'DKI Jakarta' => 'Jakarta',
            'Jawa Barat' => 'Bandung',
            'Banten' => 'Serang',
            'Jawa Tengah' => 'Semarang',
            'DI Yogyakarta' => 'Yogyakarta',
            'Jawa Timur' => 'Surabaya',
            'Bali' => 'Denpasar',
            'Nusa Tenggara Barat' => 'Mataram',
            'Nusa Tenggara Timur' => 'Kupang',
            'Kalimantan Barat' => 'Pontianak',
            'Kalimantan Tengah' => 'Palangkaraya',
            'Kalimantan Selatan' => 'Banjarmasin',
            'Kalimantan Timur' => 'Samarinda',
            'Kalimantan Utara' => 'Tanjung Selor',
            'Sulawesi Utara' => 'Manado',
            'Sulawesi Tengah' => 'Palu',
            'Sulawesi Selatan' => 'Makassar',
            'Sulawesi Tenggara' => 'Kendari',
            'Gorontalo' => 'Gorontalo',
            'Sulawesi Barat' => 'Mamuju',
            'Maluku' => 'Ambon',
            'Maluku Utara' => 'Sofifi',
            'Papua' => 'Jayapura',
            'Papua Barat' => 'Manokwari',
            'Papua Tengah' => 'Nabire',
            'Papua Pegunungan' => 'Wamena',
            'Papua Selatan' => 'Merauke',
            'Papua Barat Daya' => 'Sorong',
        ];

        foreach ($provinceCapitals as $province => $capital) {
            $provinceId = DB::table('provinces')->where('name', $province)->value('id');

            if ($provinceId) {
                DB::table('cities')->insert([
                    'province_id' => $provinceId,
                    'name' => $capital,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
