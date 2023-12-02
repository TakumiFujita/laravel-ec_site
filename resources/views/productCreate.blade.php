@extends('layout')

@section('title', '商品登録ページ')

@section('content')
    <link href="{{ asset('css/productCreate.css') }}" rel="stylesheet" type="text/css">

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
            <h1>商品登録ページ</h1>
            <form action="{{ route('productStore') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="title-wrap">商品タイトル : <input type="text" name="name" placeholder="商品タイトル"
                        value="{{ old('name') }}" class="border rounded border-sky-500"></div>
                <div class="img-wrap">商品画像 : <input type="file" name="imgpath" accept="image/jpg,image/png"
                        onchange="previewImage(this)">
                    <img id="img-preview" class="mt-3 ml-20" src="{{ asset('storage/images/') }}" alt="">

                </div>
                <div class="detail-wrap">商品説明 :
                    <textarea type="text" name="detail" cols="30" rows="10" placeholder="商品説明"
                        class="border rounded border-sky-500">{{ old('detail') }}</textarea>
                </div>
                <div class="fee-wrap">値段 : <input type="text" name="fee" placeholder="10000"
                        value="{{ old('fee') }}" class="border rounded border-sky-500">円</div>
                <div class="button-wrap flex mt-10">
                    <a class="back bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full mr-5"
                        href="{{ route('admin') }}">管理画面に戻る</a>
                    <input type="submit"
                        value="登録する"class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full cursor-pointer">
                </div>
            </form>
        </div>
        <script>
            // 画像が選択されたときに呼び出される関数
            function previewImage(input) {
                // 画像のプレビューを表示するための <img> タグの要素を取得
                var preview = document.getElementById('img-preview');

                // 選択されたファイルを取得
                var file = input.files[0];

                // FileReader オブジェクトを作成
                var reader = new FileReader();

                // FileReader が読み込みを完了したときの処理
                reader.onloadend = function() {
                    // プレビューの <img> タグの src 属性に読み込んだデータの URL を設定
                    preview.src = reader.result;
                }

                // 選択されたファイルがある場合
                if (file) {
                    // ファイルを読み込む
                    reader.readAsDataURL(file);
                } else {
                    // ファイルがない場合はプレビューを空にする
                    preview.src = "";
                }
            }
        </script>
    </body>
@endsection
