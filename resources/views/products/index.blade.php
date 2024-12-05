@extends('layouts.app')

@section('content')
<div class="container max-w-7xl mx-auto left-0 right-0 px-4 py-5">
    <h1 class="text-center text-3xl font-sans text-gray-800 mb-6">Web Scraping de Produtos</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($products as $product)
        <div class="transform transition duration-300 hover:-translate-y-2 hover:shadow-lg">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-52 object-cover">
                <div class="p-4 bg-gray-50 text-center">
                    <h5 class="text-xl font-bold text-gray-800 mb-3">
                        {{ $product->name }}
                    </h5>
                    <p class="text-sm text-gray-600 truncate mb-2" title="{{ $product->description }}">
                        {{ $product->description }}
                    </p>
                    <p class="text-base font-bold text-green-600">
                        Preço: R$ {{ number_format($product->price, 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection
