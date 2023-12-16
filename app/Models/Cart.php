<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'stock_id',
        'user_id',
    ];

    public function addCart($stock_id)
    {
        $user_id = Auth::id();
        $cart_add_info = Cart::firstOrCreate(['stock_id' => $stock_id, 'user_id' => $user_id]);

        if ($cart_add_info->wasRecentlyCreated) {
            $message = 'カートに追加しました';
        } else {
            $message = 'カートに登録済みです';
        }

        return $message;
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function showCart()
    {
        $user_id = Auth::id();
        $data['my_carts'] = $this->where('user_id', $user_id)->get();

        $data['count'] = 0;
        $data['sum'] = 0;

        foreach ($data['my_carts'] as $my_cart) {
            $data['count']++;
            $data['sum'] += $my_cart->stock->fee;
        }

        return $data;
    }

    public function deleteCart($stock_id)
    {
        $user_id = Auth::id();
        $delete = $this->where('user_id', $user_id)->where('stock_id', $stock_id)->delete();

        if ($delete > 0) {
            $message = 'カートから1つの商品を削除しました';
        } else {
            $message = '削除に失敗しました';
        }
        return $message;
    }

    public function purchaseCart()
    {
        $user_id = Auth::id();
        $purchase_items = $this->where('user_id', $user_id)->get();
        // 合計金額
        $totalAmount = 0;
        foreach ($purchase_items as $item) {
            $stock_id = $item->stock_id;
            $stock = Stock::where('id', $stock_id)->first();
            // fee が存在する場合、合計金額に加算
            if ($stock) {
                $totalAmount += $stock->fee;
            }
        }

        // 購入テーブルへデータを挿入
        $purchaseModel = new Purchase();
        $purchaseModel->addToPurchaseTbl(
            $user_id,
            $totalAmount,
        );

        // 購入テーブルに登録されたデータの購入IDを取得
        $latestPurchase = $purchaseModel->latest('purchased_id')->first();
        $purchaseId = $latestPurchase->purchased_id;

        // 購入明細テーブルへデータを挿入
        $purchaseDetailModel = new PurchaseDetail();
        $purchaseDetailModel->addToPurchaseDetailTbl($purchase_items, $purchaseId);

        // カート内の商品を全て削除
        $this->deleteCartAll();
    }

    public function deleteCartAll()
    {
        $user_id = Auth::id();
        // ユーザーがカートに入れていた商品のidを取得
        $this->where('user_id', $user_id)->delete();
    }
}
