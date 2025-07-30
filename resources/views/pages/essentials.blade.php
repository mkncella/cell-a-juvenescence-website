@extends('layouts.app')

@section('title', 'Cell-a Juvenescence Indonesia')

@section('content')

    <section class="head-section p-8">
        <div class=" bg-blue-200 min py-12 flex flex-col items-center justify-center rounded-md">
            <h2 class="text-white text-2xl">Nourish, Hydrate, and Soothe Your Skin</h2>
        </div>
    </section>

    <section class="products-section flex gap-2 md:gap-4 lg:gap-8 px-12 py-8" x-data="() => ({
        test: true,
        arg_concerns: @js($arg_concerns),
        filter_concerns: [],
        init() {
            {{-- console.log({ arg_concerns: this.arg_concerns }) --}}
        },
        uppering(text) {
            return text?.replace(/^[a-z]/, (text) => text.toUpperCase())
        },
        toggleFilterConcern(name) {
            if (!name) return

            if (this.filter_concerns.includes(name)) {
                this.filter_concerns = this.filter_concerns.filter((c) => c != name)
            } else {
                this.filter_concerns.push(name)
            }
        },
    })">
        <div class="filter-product flex flex-col gap-12">
            <div class="filter-product-by-category flex flex-col md:gap-2">
                <h3 class="text-xl font-bold">SkinCare</h3>
                <ul class="list-none flex flex-col gap-2 justify-start !pl-0 ml-0">
                    @foreach ($categories as $c)
                    <li class="inline-flex justify-between items-center gap-4 md:!gap-8">
                        <span>{{ ucfirst($c) }}</span>
                        <span class="w-4 grid place-content-center transform rotate-90 aspect-square">&gt;</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <div
                class="filter-product-by-concern flex flex-col md:gap-2"
                x-data="() => ({
                    skinConcerns: @js($skin_concerns)
                })"
                >
                <h3 class="text-xl font-bold">Skin Concern</h3>
                <ul class="list-none flex flex-col gap-2 justify-start !pl-0 ml-0">
                    <template x-for="concern in skinConcerns" :key="concern.id">
                    <li class="inline-flex justify-between items-center gap-4 md:!gap-8">
                        <span x-text="concern.name"></span>
                        <span class="w-4 grid place-content-center transform rotate-90 aspect-square">&gt;</span>
                    </li>
                    </template>
                </ul>
            </div>


        </div>

        @php
            $date = Date('Y-m-d');
            $datetime_now = new DateTime($date);
        @endphp

        <div class="flex flex-col gap-2 md:gap-4">
            <div class="card-list flex flex-wrap items-center justify-center w-full gap-4">
                @foreach ($products as $product)
                    @php
                        $datetime_product = new DateTime($product['date']);
                        $interval = $datetime_product->diff($datetime_now);
                        // $days = $interval->days;
                        $days = $interval->format('%r%a');
                        
                        // less than 30 day
                        $isNewProduct = $days < 30 & $days > 0;
    
                        if (!function_exists('rupiah')) {
                            function rupiah($angka)  {
                                return 'Rp ' . number_format($angka, 0, ',', '.');
                            }
                        }
                    @endphp
    
                    <div class="group flex-1 basis-52 max-w-[16rem] rounded-lg p-4 border overflow-hidden relative box-border h-60" x-data="{
                        isLiked: false,
                        toggle() {
                            this.isLiked = !this.isLiked
                        }
                    }">
                        <div class="head">
                            <img src="{{ asset('images/products/' . $product['image']) }}" alt="{{ $product['name'] ?? "product name" }}" class="object-cover w-full h-24">
    
                            <div class="absolute top-0 left-0 right-0 flex justify-between gap-4">
                                {{-- left for discount, new product --}}
                                <div class="text-white absolute text-xs">
                                    <div class="bg-red-600 text-center py-0.5 px-1 {{ $product['discount'] ? "" : "hidden" }}">{{ $product['discount'] }}%</div>
                                    <div class="bg-black text-center py-0.5 px-1 {{ $isNewProduct ? "" : "hidden" }}">{{ $isNewProduct ? "New!" : "" }}</div>
                                </div>
    
                                {{-- right for love? --}}

                                <div class="absolute top-2 right-2 cursor-pointer">
                                    <div class=""
                                        x-show="!isLiked"
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave-end="opacity-0 -translate-y-2 scale-90"
                                        @click="toggle"
                                    >
                                        <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.5,4.609A5.811,5.811,0,0,0,16,2.5a5.75,5.75,0,0,0-4,1.455A5.75,5.75,0,0,0,8,2.5A5.811,5.811,0,0,0,3.5,4.609c-.953,1.156-1.95,3.249-1.289,6.66c1.055,5.447,8.966,9.917,9.3,10.1a1,1,0,0,0,.974,0c.336-.187,8.247-4.657,9.3-10.1C22.45,7.858,21.453,5.765,20.5,4.609Zm-.674,6.28C19.08,14.74,13.658,18.322,12,19.34c-2.336-1.41-7.142-4.95-7.821-8.451-.513-2.646.189-4.183.869-5.007A3.819,3.819,0,0,1,8,4.5a3.493,3.493,0,0,1,3.115,1.469a1.005,1.005,0,0,0,1.76.011A3.489,3.489,0,0,1,16,4.5a3.819,3.819,0,0,1,2.959,1.382C19.637,6.706,20.339,8.243,19.826,10.889Z"/>
                                        </svg>
                                    </div>
    
                                    <div class=""
                                        x-show="isLiked"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-2"
                                        @click="toggle"
                                    >
                                        <svg class="w-6 h-6 text-red-700" fill="currentColor" viewBox="0 0 24 24">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M20.808,11.079C19.829,16.132,12,20.5,12,20.5s-7.829-4.368-8.808-9.421C2.227,6.1,5.066,3.5,8,3.5a4.444,4.444,0,0,1,4,2,4.444,4.444,0,0,1,4-2C18.934,3.5,21.773,6.1,20.808,11.079Z"></path></g>
                                        </svg>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="body pt-6 transition-all ease-in-out">
                            <p class="text-base font-bold mb-1 duration-300 group-hover:-translate-y-3">{{ $product['name'] }}</p>
                            <p class="text-xs mb-1 duration-300 group-hover:-translate-y-3 ease-in">{{ Str::limit($product['description'], 20, '...') }}</p>
                            <p class="relative flex justify-start items-center font-bold duration-500
                                    group-hover:opacity-0 group-hover:translate-y-4">
                                <span class="text-sm">
                                    {{ rupiah($product['price'] - (!$product['discount'] ? 0 : ($product['price'] * $product['discount'] / 100))) }}
                                </span>
                                @if ($product['discount'])
                                    <span class="text-[10px] text-gray-500 line-through ml-2">
                                        {{ rupiah($product['price']) }}
                                    </span>
                                @endif
                            </p>
                            <p class="flex flex-wrap items-center gap-1 w-full translate-y-[-2.75rem] opacity-0 ease-in group-hover:!opacity-100 scale-50 group-hover:scale-100 origin-left duration-300 group-hover:delay-[200ms]">
                                <template x-for="(concern, index) in @js($product['skin_concerns'])" :key="index">
                                    <span class="inline-block py-1 px-2 bg-linear-to-r from-blue-500 via-blue-400 to-blue-600 text-white rounded-lg text-xs text-[.55rem]" x-text="concern.name"></span>
                                </template>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-center">
                <p class="bg-linear-to-r from-blue-500 via-blue-400 to-blue-700 bg-clip-text text-transparent">
                    Load More
                </p>
                {{-- <button
  class="bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white px-4 py-2 rounded"
  style="
    transition-property: background-color, color;
    transition-duration: 300ms, 300ms;
    transition-delay: 0ms, 300ms;
  "
>
  Hover Me
</button> --}}



            </div>
        </div>
    </section>

@endsection