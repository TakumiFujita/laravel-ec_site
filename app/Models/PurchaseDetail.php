<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchased_detail_id',
        'item_id',
        'purchase_number',
        'purchased_id',
    ];

    // 購入明細テーブルの更新
    public function addToPurchaseDetailTbl($purchase_items, $purchaseId)
    {
        $purchased_detail_num = 0;
        foreach ($purchase_items as $item) {
            $stock_id = $item->stock_id;

            $purchased_detail_num += 1;
            $this->create([
                'purchased_detail_id' => $purchased_detail_num,
                'item_id' => $stock_id,
                'purchase_number' => 1,
                'purchased_id' => $purchaseId,
            ]);
        }
    }
}
