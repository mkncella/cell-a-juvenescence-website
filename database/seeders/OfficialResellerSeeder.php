<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\OfficialReseller;
use Illuminate\Database\Seeder;

class OfficialResellerSeeder extends Seeder
{
    public function run()
    {
        $resellers = [
            ['nama_toko' => 'Cell-a Aceh', 'alamat' => 'Jln. Merdeka No. 1, Banda Aceh', 'no_hp' => '081234000001', 'kota' => 'Banda Aceh'],
            ['nama_toko' => 'Cell-a Sumut', 'alamat' => 'Jln. Sisingamangaraja No. 2, Medan', 'no_hp' => '081234000002', 'kota' => 'Medan'],
            ['nama_toko' => 'Cell-a Sumbar', 'alamat' => 'Jln. Sudirman No. 3, Padang', 'no_hp' => '081234000003', 'kota' => 'Padang'],
            ['nama_toko' => 'Cell-a Riau', 'alamat' => 'Jln. Diponegoro No. 4, Pekanbaru', 'no_hp' => '081234000004', 'kota' => 'Pekanbaru'],
            ['nama_toko' => 'Cell-a Kep. Riau', 'alamat' => 'Jln. Raja Haji No. 5, Tanjungpinang', 'no_hp' => '081234000005', 'kota' => 'Tanjungpinang'],
            ['nama_toko' => 'Cell-a Jambi', 'alamat' => 'Jln. MH Thamrin No. 6, Jambi', 'no_hp' => '081234000006', 'kota' => 'Jambi'],
            ['nama_toko' => 'Cell-a Sumsel', 'alamat' => 'Jln. Basuki Rahmat No. 7, Palembang', 'no_hp' => '081234000007', 'kota' => 'Palembang'],
            ['nama_toko' => 'Cell-a Bengkulu', 'alamat' => 'Jln. Ahmad Yani No. 8, Bengkulu', 'no_hp' => '081234000008', 'kota' => 'Bengkulu'],
            ['nama_toko' => 'Cell-a Lampung', 'alamat' => 'Jln. Raden Intan No. 9, Bandar Lampung', 'no_hp' => '081234000009', 'kota' => 'Bandar Lampung'],
            ['nama_toko' => 'Cell-a Banten', 'alamat' => 'Jln. Jendral Sudirman No. 10, Serang', 'no_hp' => '081234000010', 'kota' => 'Serang'],
            ['nama_toko' => 'Cell-a Jakarta', 'alamat' => 'Jln. MH Thamrin No. 11, Jakarta Pusat', 'no_hp' => '081234000011', 'kota' => 'Jakarta Pusat'],
            ['nama_toko' => 'Cell-a Jabar', 'alamat' => 'Jln. Asia Afrika No. 12, Bandung', 'no_hp' => '081234000012', 'kota' => 'Bandung'],
            ['nama_toko' => 'Cell-a Jateng', 'alamat' => 'Jln. Slamet Riyadi No. 13, Semarang', 'no_hp' => '081234000013', 'kota' => 'Semarang'],
            ['nama_toko' => 'Cell-a DIY', 'alamat' => 'Jln. Malioboro No. 14, Yogyakarta', 'no_hp' => '081234000014', 'kota' => 'Yogyakarta'],
            ['nama_toko' => 'Cell-a Jatim', 'alamat' => 'Jln. Tunjungan No. 15, Surabaya', 'no_hp' => '081234000015', 'kota' => 'Surabaya'],
            ['nama_toko' => 'Cell-a Bali', 'alamat' => 'Jln. Gatot Subroto No. 16, Denpasar', 'no_hp' => '081234000016', 'kota' => 'Denpasar'],
            ['nama_toko' => 'Cell-a NTB', 'alamat' => 'Jln. Pejanggik No. 17, Mataram', 'no_hp' => '081234000017', 'kota' => 'Mataram'],
            ['nama_toko' => 'Cell-a NTT', 'alamat' => 'Jln. El Tari No. 18, Kupang', 'no_hp' => '081234000018', 'kota' => 'Kupang'],
            ['nama_toko' => 'Cell-a Kalbar', 'alamat' => 'Jln. Ahmad Yani No. 19, Pontianak', 'no_hp' => '081234000019', 'kota' => 'Pontianak'],
            ['nama_toko' => 'Cell-a Kalteng', 'alamat' => 'Jln. Imam Bonjol No. 20, Palangkaraya', 'no_hp' => '081234000020', 'kota' => 'Palangkaraya'],
            ['nama_toko' => 'Cell-a Kalsel', 'alamat' => 'Jln. A Yani No. 21, Banjarmasin', 'no_hp' => '081234000021', 'kota' => 'Banjarmasin'],
            ['nama_toko' => 'Cell-a Kaltim', 'alamat' => 'Jln. Juanda No. 22, Samarinda', 'no_hp' => '081234000022', 'kota' => 'Samarinda'],
            ['nama_toko' => 'Cell-a Kalut', 'alamat' => 'Jln. Bahagia No. 23, Tanjung Selor', 'no_hp' => '081234000023', 'kota' => 'Tanjung Selor'],
            ['nama_toko' => 'Cell-a Sulut', 'alamat' => 'Jln. Sam Ratulangi No. 24, Manado', 'no_hp' => '081234000024', 'kota' => 'Manado'],
            ['nama_toko' => 'Cell-a Sulteng', 'alamat' => 'Jln. Soekarno Hatta No. 25, Palu', 'no_hp' => '081234000025', 'kota' => 'Palu'],
            ['nama_toko' => 'Cell-a Sulsel', 'alamat' => 'Jln. Urip Sumoharjo No. 26, Makassar', 'no_hp' => '081234000026', 'kota' => 'Makassar'],
            ['nama_toko' => 'Cell-a Sultra', 'alamat' => 'Jln. Martadinata No. 27, Kendari', 'no_hp' => '081234000027', 'kota' => 'Kendari'],
            ['nama_toko' => 'Cell-a Sulbar', 'alamat' => 'Jln. Pattimura No. 28, Mamuju', 'no_hp' => '081234000028', 'kota' => 'Mamuju'],
            ['nama_toko' => 'Cell-a Gorontalo', 'alamat' => 'Jln. Diponegoro No. 29, Gorontalo', 'no_hp' => '081234000029', 'kota' => 'Gorontalo'],
            ['nama_toko' => 'Cell-a Maluku', 'alamat' => 'Jln. Pattimura No. 30, Ambon', 'no_hp' => '081234000030', 'kota' => 'Ambon'],
            ['nama_toko' => 'Cell-a Malut', 'alamat' => 'Jln. Sultan Khairun No. 31, Sofifi', 'no_hp' => '081234000031', 'kota' => 'Sofifi'],
            ['nama_toko' => 'Cell-a Papua', 'alamat' => 'Jln. Yos Sudarso No. 32, Jayapura', 'no_hp' => '081234000032', 'kota' => 'Jayapura'],
            ['nama_toko' => 'Cell-a Papua Barat', 'alamat' => 'Jln. Manokwari No. 33, Manokwari', 'no_hp' => '081234000033', 'kota' => 'Manokwari'],
            ['nama_toko' => 'Cell-a Papua Barat Daya', 'alamat' => 'Jln. A Yani No. 34, Sorong', 'no_hp' => '081234000034', 'kota' => 'Sorong'],
            ['nama_toko' => 'Cell-a Papua Tengah', 'alamat' => 'Jln. Perintis No. 35, Nabire', 'no_hp' => '081234000035', 'kota' => 'Nabire'],
            ['nama_toko' => 'Cell-a Papua Pegunungan', 'alamat' => 'Jln. Trikora No. 36, Wamena', 'no_hp' => '081234000036', 'kota' => 'Wamena'],
            ['nama_toko' => 'Cell-a Papua Selatan', 'alamat' => 'Jln. Trans Papua No. 37, Merauke', 'no_hp' => '081234000037', 'kota' => 'Merauke'],
        ];

        foreach ($resellers as $reseller) {
            $city = City::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($reseller['kota']) . '%'])->first();

            if ($city) {
                OfficialReseller::create([
                    'nama_toko' => $reseller['nama_toko'],
                    'alamat' => $reseller['alamat'],
                    'no_hp' => $reseller['no_hp'],
                    'shopee' => 'https://shopee.co.id/' . strtolower(str_replace(' ', '', $reseller['nama_toko'])),
                    'tiktok' => 'https://tiktok.com/@' . strtolower(str_replace(' ', '', $reseller['nama_toko'])),
                    'city_id' => $city->id,
                ]);
            }
        }
    }
}
