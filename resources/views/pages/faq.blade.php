@extends('layouts.app')

@section('title', 'Cell-a Juvenescence Indonesia')

@section('content')

    <section class="conn-section" x-data="{
        categories: @json($categories),
        isOpenAll: false,
        faqs: @json($faqs),
        init() {
            faqs = faqs?.map(faq => ({ ...faq, isSelected: false }))
        }
    }">
        <div class="conn-filters">
            
        </div>
    </section>

@endsection