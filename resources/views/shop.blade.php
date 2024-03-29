@extends('layout')

@section('title', '商品一覧')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/shop.css') }}">

    <body>
        <div class="shop-container">
            <h1>商品一覧</h1>
            @auth
                <div class="item-container">
                    {{ Auth::user()->name }}さんのページ
                    <a href="{{ route('mycart') }}">
                        <svg class="h-8 w-8 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                    </a>
                </div>
                <div class="flex justify-end item-container">
                    <a class="bg-white hover:bg-gray-100 text-gray-800 py-2 px-4 border border-gray-400 rounded"
                        href="{{ route('profile.edit') }}">プロフィール編集</a>
                    <a class="bg-white hover:bg-gray-100 text-gray-800 py-2 px-4 border border-gray-400 rounded"
                        href="{{ route('purchaseHistory') }}">購入履歴</a>
                    @if ($role_id === 1)
                        <a href="{{ route('admin') }}"
                            class="bg-white hover:bg-gray-100 text-gray-800 py-2 px-4 border border-gray-400 rounded">管理者</a>
                    @endif
                    <div class="cursor-pointer" onclick="event.preventDefault(); this.querySelector('form').submit();">
                        <div class="bg-white hover:bg-gray-100 text-gray-800 py-2 px-4 border border-gray-400 rounded">
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
            <div class="item-container flex justify-center">
                <form action="/index" method="GET" class="flex items-center">
                    <input type="text" name="keyword" value="{{ $keyword }}"
                        class="border rounded-l border-sky-500 py-2 px-4 w-80">
                    <button type="submit"
                        class="flex-shrink-0 bg-amber-500 hover:bg-amber-700 border-blue-500 hover:border-blue-700 text-base border-r border-t border-b text-white py-2 px-4 rounded-r">
                        <svg class="h-6 w-6 text-white-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>
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
                {{-- {{ $stocks->links('vendor.pagination.tailwind2') }} --}}
            </div>
            <div class="shop-container paginate-container">
                {{ $stocks->links('vendor.pagination.tailwind2') }}
            </div>

        </div>
    </body>
@endsection
