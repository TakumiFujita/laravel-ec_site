@extends('layout')

@section('title', 'マイカート')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/mycart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <body>
        <div class="mycart-container">
            <h1>{{ Auth::user()->name }}さんのカートの中身</h1>
            <p class="message font-bold">{{ $message ?? '' }}</p>
            @if ($my_carts->isNotEmpty())
                <div class="items">
                    @foreach ($my_carts as $my_cart)
                        <div class="item">
                            <p>{{ $my_cart->stock->name }}</p>
                            <p>{{ number_format($my_cart->stock->fee) }}円</p>
                            <img src="{{ asset('storage/images/' . $my_cart->stock->imgpath) }}" alt="">
                            <form action="{{ route('cartdelete') }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="stock_id" value="{{ $my_cart->stock->id }}">
                                <div class="flex justify-center">
                                    <input type="submit" value="カートから削除する"
                                        class="mt-2 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-full cursor-pointer"
                                        onClick="return confirm('本当に削除しますか？');">
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="purchase">
                    <p>個数 : {{ $count }}個</p>
                    <p>合計金額 : {{ number_format($sum) }}円</p>
                    <div class="flex justify-center space-x-2">
                        <a href="{{ route('shop') }}"
                            class="index bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full cursor-pointer"
                            style="text-decoration: none;">商品一覧へ</a>
                        <form id="purchaseForm" action="/purchase" method="POST">
                            @csrf
                            <button type="button" id="button"
                                class="bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-full cursor-pointer">購入する</button>
                        </form>
                    </div>
                </div>
            @else
                <p class="empty">カートには商品が入っていません</p>
                <div class="flex justify-center space-x-2">
                    <a href="{{ route('shop') }}"
                        class="index bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full cursor-pointer"
                        style="text-decoration: none;">商品一覧へ</a>
                </div>
            @endif

        </div>
        </div>
        <script src="{{ asset('js/common.js') }}"></script>
        <script>
            const button = document.getElementById('button');

            button.addEventListener('click', function(e) {

                const confirm = window.confirm('購入しますか？');

                if (confirm) {
                    purchaseForm.submit();
                }
                if (confirm) {
                    button.classList.add('disable');
                }
            });
        </script>
    </body>
@endsection
