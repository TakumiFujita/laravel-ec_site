@extends('layout')

@section('title', '商品一覧')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/shop.css') }}">

    <body>
        <div class="shop-container">
            <h1>購入履歴</h1>
            <div class="item-container">
                @foreach ($purchased_items_arr as $purchased_item)
                    <div class="item">
                        <p class="text-center">商品名：{{ $purchased_item['name'] }}</p>
                        <div><img src="{{ asset('storage/images/' . $purchased_item['imgpath']) }}" alt=""></div>
                        <p class="text-center">購入日時：{{ $purchased_item['date'] }}</p>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center space-x-2">
                <a href="{{ route('shop') }}"
                    class="index bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full cursor-pointer"
                    style="text-decoration: none;">商品一覧へ</a>
            </div>
        </div>
    </body>
@endsection
