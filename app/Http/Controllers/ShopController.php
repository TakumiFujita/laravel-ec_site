<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Stock $stock)
    {
        $stocks = $stock->stockDisplay();
        $user = Auth::user();

        if (is_null($user)) {
            // ログインユーザーでない場合は、役割idを0に設定
            $role_id = 0;
        } else {
            // ログインユーザーの場合は役割idを取得
            $role = $user->roles->first();
            $role_id = $role->id;
        }
        return view('shop', compact('stocks', 'role_id'));
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

    public function redirect()
    {
        return redirect('index');
    }

    public function admin(Stock $stock)
    {
        $stocks = $stock->stockDisplay();
        return view('admin', compact('stocks'));
    }

    public function itemDelete($id)
    {
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
        $stock->store($request);

        return back()->with('message', '商品の更新が完了しました');
    }
}
