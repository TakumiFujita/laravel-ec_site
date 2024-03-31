@extends('layout')

@section('title', 'お気に入り')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/mycart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <body>
        <div class="mycart-container  shop-container">
            <h1>{{ Auth::user()->name }}さんのお気に入り商品一覧</h1>
            <p class="message font-bold">{{ $message ?? '' }}</p>
            @if ($favorites->isNotEmpty())
                <div class="items item-container">
                    @foreach ($favorites as $favorite)
                        <div class="item">
                            <div class="favorite w-72">
                                <button class="material-symbols-outlined text-gray-500 favorited"
                                    data-stock-id="{{ $favorite->item_id }}">
                                    delete
                                </button>
                            </div>
                            <p>{{ $favorite->stock->name }}</p>
                            <p class="text-center">{{ number_format($favorite->stock->fee) }}円</p>
                            <img src="{{ asset('storage/images/' . $favorite->stock->imgpath) }}" alt="">
                            <form action="{{ route('addmycart') }}" method="post" class="form">
                                @csrf
                                <input type="hidden" name="stock_id" value="{{ $favorite->stock->id }}">
                                <div class="flex justify-center">
                                    <input type="submit" value="カートに入れる"
                                        class="addcart mt-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full cursor-pointer">
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="purchase">
                    <div class="flex justify-center space-x-2">
                        <a href="{{ route('shop') }}"
                            class="index bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full cursor-pointer"
                            style="text-decoration: none;">商品一覧へ</a>
                    </div>
                </div>
            @else
                <p class="empty">お気に入りに登録されている商品はありません</p>
                <div class="flex justify-center space-x-2">
                    <a href="{{ route('shop') }}"
                        class="index bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full cursor-pointer"
                        style="text-decoration: none;">商品一覧へ</a>
                </div>
            @endif

        </div>
        </div>
        <script src="{{ asset('js/common.js') }}"></script>
    </body>
@endsection
<script>
    // DOMが完全に読みこまれた後にコードを実行
    document.addEventListener("DOMContentLoaded", function() {
        const favoriteItems = document.querySelectorAll('.favorited');
        favoriteItems.forEach(item => {
            item.addEventListener('click', function() {
                // クリックした要素のdata-stock-id属性の属性値を取得し、商品idを取得
                const stockId = this.getAttribute('data-stock-id');

                // お気に入りの削除処理を行う
                removeFromFavorites(stockId)
                    .then(response => {
                        // 画面を更新する
                        if (response.ok) {
                            // 削除された商品のDOM要素を取得し、それを削除する
                            const itemContainer = this.closest('.item');
                            itemContainer.remove();
                        }
                    })
                    .catch(error => {
                        console.error('お気に入りの削除に失敗しました:', error);
                        // 失敗時の処理をここに書く
                    });
            });
        });

        // お気に入り削除処理
        async function removeFromFavorites(stockId) {
            try {
                const response = await fetch('/removeFromFavorites', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        stock_id: stockId
                    })
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response;
            } catch (error) {
                console.error('There was a problem with your fetch operation:', error);
                throw error;
            }
        }
    });
</script>
