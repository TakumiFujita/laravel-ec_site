<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'purchase_number',
        'purchased_id',
    ];

    // 購入明細テーブルの更新
    public function addToPurchaseDetailTbl($purchase_items, $purchaseId)
    {
        foreach ($purchase_items as $item) {
            $stock_id = $item->stock_id;
            $stock = Stock::where('id', $stock_id)->first();
        }
        $this->create([
            'item_id' => $stock->id,
            'purchase_number' => 1,
            'purchased_id' => $purchaseId,
        ]);
    }
}
