@extends('layout')

@section('title', '商品一覧')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/shop.css') }}">

    <body>
        <div class="shop-container">
            <h1>商品一覧</h1>
            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            <div class="item-container">
                @foreach ($stocks as $stock)
                    <div class="item">
                        <p>{{ $stock->name }}<br>{{ $stock->fee }}円</p>
                        <div><img src="{{ asset('storage/images/' . $stock->imgpath) }}" alt=""></div>
                        <p>{{ $stock->detail }}</p>
                        <form action="{{ route('addmycart') }}" method="post" class="form">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                            <input type="submit" value="カートに入れる" class="addcart">
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
@endsection
