<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Cart;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ShopController extends Controller
{
    public function index(Request $request, Stock $stock)
    {
        // キーワードを取得
        $keyword = $request->input('keyword');

        $query = Stock::query();
        // キーワードが空でない場合、商品名or商品説明から一致するものを検索する
        if (!empty($keyword) || $keyword == '0') {
            // 全角スペースを半角スペースに変換
            $keyword = mb_convert_kana($keyword, 's');
            // 半角スペースで区切り、配列にする
            $keywords_arr = preg_split('/[\s]+/', $keyword);
            // 複数のキーワードが、nameかdetailのどちらかにマッチする商品を検索クエリを作成
            $query->where(function ($q) use ($keywords_arr) {
                foreach ($keywords_arr as $keyword) {
                    $q->orWhere('name', 'LIKE', "%{$keyword}%")->orWhere('detail', 'LIKE', "%{$keyword}%");
                }
            });
            // クエリ検索を実行し、条件にマッチする商品を取得
            $stocks = $query->paginate(9);
        } else {
            // キーワードが空の場合は全商品を取得
            // $stocks = $stock->stockDisplay()->paginate(9);
            $stocks = $stock->stockDisplay(9);
        }

        $user = Auth::user();

        if (is_null($user)) {
            // ログインユーザーでない場合は、役割idを0に設定
            $role_id = 0;
        } else {
            // ログインユーザーの場合は役割idを取得
            $role = $user->roles->first();
            $role_id = $role->id;
        }
        return view('shop', compact('stocks', 'keyword', 'role_id'));
    }

    public function productCreate()
    {
        return view('productCreate');
    }

    public function productStore(Stock $stock, Request $request)
    {
        $stock->store($request);
        return back()->with('message', '商品の投稿が完了しました');
    }

    public function myCart(Cart $cart)
    {
        $data = $cart->showCart();
        return view('mycart', $data);
    }

    public function addMycart(Request $request, Cart $cart)
    {
        $stock_id = $request->stock_id;
        $message = $cart->addCart($stock_id);

        $data = $cart->showCart();

        return view('mycart', $data)->with('message', $message);
    }

    public function deleteCart(Request $request, Cart $cart)
    {
        $stock_id = $request->stock_id;
        $message = $cart->deleteCart($stock_id);

        $data = $cart->showCart();

        return view('mycart', $data)->with('message', $message);
    }

    public function purchase(Request $request, Cart $cart)
    {
        $cart->purchaseCart();

        $request->session()->regenerateToken();

        return view('purchase');
    }

    public function addToFavorites(Request $request)
    {
        $stock_id = $request->stock_id;
        $user = Auth::user();
        //お気に入りテーブルにデータを挿入
        $favorite = new Favorite();
        $favorite->user_id = $user->id;
        $favorite->item_id = $stock_id;
        $favorite->save();

        return back()->with('success', '商品をお気に入りに追加しました');
    }

    public function removeFromFavorites(Request $request)
    {
        $stock_id = $request->stock_id;
        $user = Auth::user();
        //お気に入りテーブルからデータを削除
        Favorite::where('user_id', $user->id)->where('item_id', $stock_id)->delete();

        // return back()->with('success', '商品をお気に入りから削除しました');
    }

    public function favoritesList()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $favorites = Favorite::where('user_id', $user_id)->get();
        return view('favorite', ['favorites' => $favorites]);
    }

    public function redirect()
    {
        return redirect('index');
    }

    public function admin(Stock $stock)
    {
        $stocks = $stock->stockDisplay(10);
        return view('admin', compact('stocks'));
    }

    public function itemDelete($id)
    {
        $stock = Stock::find($id);

        // 商品画像を削除
        $this->deleteLocalImage($stock);

        Stock::destroy($id);
        return back();
    }

    public function edit($id)
    {
        $stockEdit = Stock::find($id);
        return view('edit', compact('stockEdit'));
    }

    public function update(Stock $stock, Request $request)
    {
        // 商品画像を削除
        $this->deleteLocalImage($stock);

        $stock->store($request);
        return back()->with('message', '商品の更新が完了しました');
    }

    public function deleteLocalImage(Stock $stock)
    {
        // 商品をデータベースから削除前に画像パスを取得
        if (!$stock) {
            return back()->with('error', '商品が見つかりませんでした。');
        }

        $imagePath = public_path("storage/images/{$stock->imgpath}");

        // 商品画像を削除
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    public function displayHistory()
    {
        $user = Auth::user();
        $user_id = Auth::id();
        // 購入商品を取得
        // 購入テーブルより、購入者IDに紐づくpurchased_idを全て取得
        $purchased_items = Purchase::where('purchaser_id', $user_id)->orderby('purchased_time', 'desc')->get();
        // dd($purchased_items);
        // 購入明細テーブルより、purchased_idに紐付くitem_idを全て取得

        // viewに渡す際の連想配列を定義
        $purchased_items_arr = [];

        foreach ($purchased_items as $purchased_item) {
            $purchased_id = $purchased_item->purchased_id;
            // dd($purchased_id);
            $purchased_details = PurchaseDetail::where('purchased_id', $purchased_id)->get();
            // dd($purchased_details);
            foreach ($purchased_details as $purchased_detail) {
                $item_id = $purchased_detail->item_id;
                // $purchase_day = $purchased_detail->created_at;
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $purchased_detail->created_at)->format('Y年m月d日 H:i');
                $stock = Stock::where('id', $item_id)->first();
                // dd($stock);

                $purchased_items_arr[] = array(
                    'name' => $stock->name,
                    'imgpath' => $stock->imgpath,
                    'date' => $date,
                );
            }
        }
        // dd($purchased_items_arr);
        return view('purchaseHistory', compact('purchased_items_arr'));
    }
}
