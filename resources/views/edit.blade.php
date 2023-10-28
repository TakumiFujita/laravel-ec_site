@extends('layout')

@section('title', '商品編集')

@section('content')
    <link href="{{ asset('css/productCreate.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet" type="text/css">

    <body>
        <div class="productCreate-container">
            @if (session('message'))
                <div class="flash">
                    {{ session('message') }}
                </div>
            @endif
            @if ($errors->any())
                <ul class="error">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <a class="back" href="{{ route('admin') }}">管理画面に戻る</a>
            <h1>商品編集ページ</h1>
            <form action="{{ route('update', ['stock' => $stockEdit]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="title-wrap">商品タイトル : <input type="text" name="name" placeholder="商品タイトル"
                        value="{{ old('name', $stockEdit->name) }}"></div>
                <div class="img-wrap">商品画像 : <input type="file" name="imgpath" accept="image/jpg,image/png"></div>
                <div class="detail-wrap">商品説明 :
                    <textarea type="text" name="detail" cols="30" rows="10" placeholder="商品説明">{{ old('detail', $stockEdit->detail) }}</textarea>
                </div>
                <div class="fee-wrap">値段 : <input type="text" name="fee" placeholder="10000"
                        value="{{ old('fee', $stockEdit->fee) }}">円</div>
                <div class="submit-wrap"><input type="submit" value="登録する"></div>
            </form>
        </div>
    </body>
@endsection
