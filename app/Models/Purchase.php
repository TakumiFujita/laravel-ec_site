<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchased_time',
        'purchased_month',
        'purchaser_id',
        'purchased_amount',
    ];

    // 購入テーブルの更新
    public function addToPurchaseTbl($user_id, $totalAmount)
    {
        $this->create([
            'purchased_time' => now(),
            'purchased_month' => now()->month,
            'purchaser_id' => $user_id,
            'purchased_amount' => $totalAmount,
        ]);
    }
}
