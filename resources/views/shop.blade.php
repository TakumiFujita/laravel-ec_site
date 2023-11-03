@extends('layout')

@section('title', '商品一覧')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/shop.css') }}">

    <body>
        <div class="shop-container">
            <h1>商品一覧</h1>
            @auth
                <div class="item-container">{{ Auth::user()->name }}さんのページ</div>
                <div class="flex justify-end item-container">
                    <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded"
                        href="{{ route('profile.edit') }}">プロフィール編集ページ</a>
                    @if ($role_id === 1)
                        <a href="{{ route('admin') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded">管理者ページ</a>
                    @endif
                    <div class="cursor-pointer" onclick="event.preventDefault(); this.querySelector('form').submit();">
                        <div class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
            <div class="item-container">
                @foreach ($stocks as $stock)
                    <div class="item">
                        <p>{{ $stock->name }}<br>{{ $stock->fee }}円</p>
                        <div><img src="{{ asset('storage/images/' . $stock->imgpath) }}" alt=""></div>
                        <p class="text-center">{{ $stock->detail }}</p>
                        <form action="{{ route('addmycart') }}" method="post" class="form">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                            <input type="submit" value="カートに入れる"
                                class="addcart bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full cursor-pointer">
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
@endsection
