@extends('layout')

@section('title', '管理画面')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <body>
        <div class="admin-container">
            <h1>商品管理ページ</h1>
            @auth
                <div class="mt-10">
                    <a href="{{ route('shop') }}"
                        class="index bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full cursor-pointer">商品画面へ</a>
                    <a href="{{ route('mycart') }}"
                        class="index bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full cursor-pointer">マイカートへ</a>
                    <a href="{{ route('productCreate') }}"
                        class="index bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full cursor-pointer">商品登録画面へ</a>
                </div>
            @endauth
            @foreach ($stocks as $stock)
                <div class="item">
                    <img src="{{ asset('storage/images/' . $stock->imgpath) }}" alt="">
                    <div>
                        <h2>商品名 : {{ $stock->name }}</h2>
                        <p>商品の説明 : {{ $stock->detail }}</p>
                        <a href="{{ route('edit', ['id' => $stock->id]) }}" class="edit">編集</a>
                        <form class="delete" method="post" action="{{ route('delete', ['id' => $stock->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onClick="return confirm('本当に削除しますか？');">削除</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </body>
@endsection
