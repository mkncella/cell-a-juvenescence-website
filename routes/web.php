<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResellerController;
use Illuminate\Http\Request;

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

    $stores = [
        [
            "title" => "Kosmetik ku",
            "description" => "Toko termurah terasli",
            "address" => ""
        ]
    ];

    return view('pages.reseller-fix');
});

Route::get('/reseller-cell-a', [ResellerController::class, 'index'])->name('reseller');
