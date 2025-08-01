<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResellerController;
use Illuminate\Http\Request;

function resolveShortLink($shortUrl)
{
    $ch = curl_init($shortUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // ini yang penting
    curl_exec($ch);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    return $finalUrl;
}

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/about-us', function () {
    return view('pages.about-us');
});

Route::get('/essentials', function (Request $request) {

    $skin_concerns = [
        [
            "id" => 1,
            "name" => "Kulit Berkomedo"
        ],
        [
            "id" => 2,
            "name" => "Kulit Berjerawat"
        ],
        [
            "id" => 3,
            "name" => "Kulit Kusam"
        ],
        [
            "id" => 4,
            "name" => "Kulit Sensitif"
        ],
        [
            "id" => 5,
            "name" => "Kulit Aging"
        ],
        [
            "id" => 6,
            "name" => "Kulit Hitam"
        ],
        [
            "id" => 7,
            "name" => "Kulit Gelap"
        ],
    ];

    $products = [
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-08-22",
            "image" => "product-1.jpg",
            "category" => "Cleanser",
            "list_skin_concern_id" => [1,2,3,4,5]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 20,
            "date" => "2025-07-22",
            "image" => "product-1.jpg",
            "category" => "mask",
            "list_skin_concern_id" => [1,2,3,4]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-05-22",
            "image" => "product-1.jpg",
            "category" => "moisturizer",
            "list_skin_concern_id" => [2,4]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 10,
            "date" => "2025-07-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [1,4]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 80,
            "date" => "2025-01-22",
            "image" => "product-1.jpg",
            "category" => "Treatment",
            "list_skin_concern_id" => [3,4]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [1,2]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [1,2]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [1,4]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [1,3]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [1,4]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [2,3]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [1,4]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [1,2]
        ],
        [
            "name" => "Cell-a",
            "description" => "Blemish Balm BB Cream",
            "price" => 100000,
            "discount" => 0,
            "date" => "2025-04-22",
            "image" => "product-1.jpg",
            "category" => "serum",
            "list_skin_concern_id" => [2,3]
        ],
    ];

    // apply skin_concern to product
    $products = array_map(function ($product) use ($skin_concerns) {
        $matched_concerns = array_filter($skin_concerns, function ($concern) use ($product) {
            return in_array($concern['id'], $product['list_skin_concern_id']);
        });

        $product['skin_concerns'] = array_values($matched_concerns);

        return $product;
    }, $products);


    // get categories
    $categories = collect($products)->pluck('category')->unique()->values()->all();

    // get arg_concerns
    $arg_concerns = explode(",", $request->query("concerns"));

    return view('pages.essentials', ["products" => $products, "categories" => $categories, "skin_concerns" => $skin_concerns, "arg_concerns" => $arg_concerns]);
});

Route::get('/faq', function () {

    $topics = [
        [
            "category" => "Product",
            "qna" => [
                [
                    "question" => "Apa saja jenis produk skincare yang tersedia?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit eaque fugit sunt dolorem. Quasi incidunt excepturi asperiores! Accusamus, deleniti recusandae."
                ],
                [
                    "question" => "Apakah produk ini aman untuk semua jenis kulit?",
                    "answer" => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias beatae eaque enim!"
                ],
                [
                    "question" => "Apakah produk ini mengandung bahan yang berbahaya?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat atque facilis delectus soluta! Totam amet, accusamus libero ab delectus nesciunt quo illum dolorum quos impedit modi reiciendis suscipit, alias voluptatem?"
                ],
                [
                    "question" => "Berapa kali sehari saya harus menggunakan menggunakan produk skincare?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis, odio assumenda earum alias id vero debitis, facere expedita, doloribus tempora saepe adipisci iure tempore ad?"
                ],
                [
                    "question" => "Bagaimana cara mengetahui apakah  saya alergi terhadap suatu produk?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla explicabo ad dolor voluptates velit distinctio delectus minima eum ex ducimus consequatur aliquid nostrum quam iure nihil alias amet dicta quas, laboriosam totam neque, officia laudantium doloribus! Qui deleniti pariatur reiciendis."
                ],
                [
                    "question" => "Bagaimana cara menyimpan produk skincare dengan benar?",
                    "answer" => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni quod at recusandae, consequatur eaque soluta sunt ex voluptas repudiandae, enim obcaecati quos!"
                ],
            ],
        ],
        [
            "category" => "Ordering",
            "qna" => [
                [
                    "question" => "Bagaimana cara melakukan pemesanan?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum animi tenetur ea inventore quisquam laborum nobis id exercitationem enim voluptatibus odit obcaecati natus ex ratione quo, amet molestias dolorem temporibus?"
                ],
                [
                    "question" => "Mengapa saya tidak menerima email konfirmasi pesanan?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ullam quidem deleniti iusto obcaecati quod iste, numquam quam distinctio maiores consectetur dolore fugiat vero corrupti et itaque pariatur ratione dignissimos dolorem eius rem? Quaerat mollitia consectetur animi voluptas illum, fugiat sit, dolore tenetur fuga, dolor non. Amet at nam distinctio nulla."
                ],
                [
                    "question" => "Mengapa pesanan saya dibatalkan?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente placeat quas dolor sed impedit ut pariatur quae, architecto dicta? Atque, ipsam ducimus."
                ]
            ]
        ],
        [
            "category" => "Shipping and Delivery",
            "qna" => [
                [
                    "question" => "Metode pengiriman apa saja yang tersedia?",
                    "answer" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos exercitationem laborum facere itaque doloribus rerum ad eaque! Id voluptates consequuntur inventore dolorem aliquid sit dolorum!"
                ],
                [
                    "question" => "Berapa biaya pengirimannya?",
                    "answer" => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi in minima architecto molestiae quo pariatur sit quod, iusto dolor repudiandae repellendus esse. Doloremque, velit totam eius officiis libero quo ratione, consectetur praesentium eaque quia rerum animi ad optio quos illo."
                ],
                [
                    "question" => "Bagaimana cara melacak pesanan saya?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid, ipsam explicabo aspernatur autem placeat eligendi. Asperiores quidem maiores ipsa sapiente illum ullam facere aut non sint ab eos, corporis repudiandae iste vero repellendus voluptates incidunt explicabo cum labore. Vel at fugiat aliquam, deserunt perspiciatis quidem ab, maiores nobis nihil eum aspernatur debitis fugit illum atque dolores quo voluptatem. Laborum nemo reiciendis saepe recusandae voluptates? Exercitationem ad commodi perspiciatis impedit dicta."
                ],
                [
                    "question" => "Apa yang harus saya lakukan jika pesanan saya terlambat?",
                    "answer" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima quibusdam ea impedit non illo, expedita, doloremque hic, beatae mollitia ad facilis natus!"
                ]
            ]
        ]
    ];



    // get categories
    $categories = collect($topics)->pluck('category')->unique()->values()->all();



    return view('pages.faq', ["topics" => $topics, "categories" => $categories,]);
});



Route::get('/beauty-community', function () {
    return view('pages.beauty-community');
});

Route::get('/loyalty', function () {
    return view('pages.loyalty');
});

Route::get('/term-of-service', function () {
    return view('pages.term-of-service');
});

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
});

Route::get('/reseller-cell-a', function () {
    return view('pages.reseller');
});

Route::get('/reseller-fix', function () {

    $reqions = [
        'DKI Jakarta' => [
            'Jakarta Pusat',
            'Jakarta Utara',
            'Jakarta Selatan',
        ],
        'Jawa Barat' => [
            'Kota Bandung',
            'Kota Bogor',
            'Kabupaten Bekasi',
        ],
        'Bali' => [
            'Kota Denpasar',
            'Kabupaten Badung',
            'Kabupaten Gianyar',
        ],
        'Jawa Tengah' => [
            'Kota Semarang',
            'Kota Surakarta',
            'Kabupaten Magelang',
        ],
        'Sumatera Utara' => [
            'Kota Medan',
            'Kota Pematangsiantar',
            'Kabupaten Deli Serdang',
        ],
    ];


    $stores = [
        [
            "title" => "Cantika kosmetik",
            "description" => "Toko termurah terasli",
            "address" => "Pasar Rumput, BL00DCT157, Jl. Sultan Agung, RT.1/RW.3, Ps. Manggis, Kecamatan Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12970",
            "link" => "https://maps.app.goo.gl/NnARdbv6kTSVz6BNA",
            "lat" => "-6.2075605",
            "lng" => "106.6968829",
            "zoom" => "12",
            "province" => "DKI Jakarta",
            "city" => "Jakarta Utara",
        ],
        [
            "title" => "TOKO DELIMA KOSMETIK",
            "description" => "Toko Termurah dijamin murah",
            "address" => "Gg. Lurah Jl. Petamburan No.04B 6, RT.6/RW.1, Petamburan, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10260",
            "link" => "https://maps.app.goo.gl/PxAy55fiTV9T12ws6",
            "lat" => "-6.1912006",
            "lng" => "106.6650367",
            "zoom" => "12",
            "province" => "DKI Jakarta",
            "city" => "Jakarta Pusat",
        ],
        [
            "title" => "Elsa Cosmetics",
            "description" => "Toko Termurah dijamin murah Di Bandung",
            "address" => "Jl. Jamika No.27, Jamika, Kec. Bojongloa Kaler, Kota Bandung, Jawa Barat 40231",
            "link" => "https://maps.app.goo.gl/1TVjtScNbE9Sqh317",
            "lat" => "-6.9202921",
            "lng" => "107.5143635",
            "zoom" => "13",
            "province" => "Jawa Barat",
            "city" => "Kota Bandung",
        ],
        [
            "title" => "Yamela Kosmetik",
            "description" => "Toko Termurah terkeren murah Di Bekasi",
            "address" => "Jl. Pahlawan No.20, RT.001/RW.007, Duren Jaya, Kec. Bekasi Tim., Kota Bks, Jawa Barat 17111",
            "link" => "https://maps.app.goo.gl/wvSabvggPk9w6sBh8",
            "lat" => "-6.2692317",
            "lng" => "106.8903495",
            "zoom" => "12",
            "province" => "Jawa Barat",
            "city" => "Kota Bekasi",
        ],
        [
            "title" => "Olla Kosmetik",
            "description" => "Toko Termurah terkeren murah se Medan",
            "address" => "Helvetia Tengah, Kec. Medan Helvetia, Kota Medan, Sumatera Utara 20124",
            "link" => "https://maps.app.goo.gl/m9F3AmhEwJe4KZiK68",
            "lat" => "3.6139058",
            "lng" => "98.5683502",
            "zoom" => "13",
            "province" => "Sumatera Utara",
            "city" => "Kota Medan",
        ],
        [
            "title" => "PADUSHE KOSMETIK",
            "description" => "Toko Termurah terkeren murah se deliserang",
            "address" => "Jl. Pertahanan No.17, Patumbak Kp., Kec. Patumbak, Kabupaten Deli Serdang, Sumatera Utara",
            "link" => "https://maps.app.goo.gl/JEpF4U3AsC96HoDv9",
            "lat" => "3.513004",
            "lng" => "98.6942425",
            "zoom" => "14.33",
            "province" => "Sumatera Utara",
            "city" => "Kabupaten Deli Serdang",
        ],
    ];

    return view('pages.reseller-fix');
});

// Route::post("/get-latlng-by-goggle-map-link");

Route::get("/get-latlng-by-goggle-map-link", function (Request $request) {

    $link = $request->get("link");

    $resolved = resolveShortLink($link);
    // $regexs = [
    //     '/@(-?\d+\.\d+),(-?\d+\.\d+),(\d+)z/',
    //     '/@(-?\d+\.\d+),(-?\d+\.\d+),([\d\.]+)z/'
    // ];

    preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+),([\d\.]+)z/', $resolved, $matches);

    $lat = null;
    $lng = null;
    $zoom = null;

    if ($matches) {
        $lat = $matches[1];
        $lng = $matches[2];
        $zoom = $matches[3];
    }

    $result = [
        "link" => $link,
        "resolvedShortUrl" => $resolved,
        "lat" => $lat,
        "lng" => $lng,
        "zoom" => $zoom,
        "matches" => $matches,
    ];

    return $result;

    // return view("pages.get-latlng-by-goggle-map-link", ["resolved" => $resolved, "lat" => $lat, "lng" => $lng, "zoom" => $zoom, "matches" => $matches, "link" => $link]);

});

Route::get('/reseller-cell-a', [ResellerController::class, 'index'])->name('reseller');
