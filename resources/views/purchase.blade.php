@extends('layout')

@section('title', '購入ありがとうございます')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <body>
        <div class="purchase-container">
            <h1>{{ Auth::user()->name }}さんご購入ありがとうございました</h1>
            <p>ご登録頂いたメールアドレスへ決済情報をお送りしております。お手続き完了次第商品を発送致します。</p>
            <a href="/index">商品一覧へ</a>
        </div>
    </body>
@endsection
