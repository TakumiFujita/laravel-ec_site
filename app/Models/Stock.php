<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'detail',
        'fee',
        'imgpath'
    ];

    public function store($request)
    {
        $inputs = $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'fee' => 'required',
            'imgpath' => 'required',
        ]);

        $this->name = $inputs['name'];
        $this->detail = $inputs['detail'];
        $this->fee = $inputs['fee'];
        $originalName = $request->file('imgpath')->getClientOriginalName();
        $name = date('Yms_His') . '_' . $originalName;
        $request->file('imgpath')->move('storage/images', $name);
        $this->imgpath = $name;
        $this->save();
    }

    public function stockDisplay($i)
    {
        return Stock::paginate($i);
    }

    public function isFavoritedByUser($userId, $stockId)
    {
        // ユーザーIDと商品IDの組み合わせがお気に入りテーブルに存在するかどうかを確認
        return $this->favorites()->where('user_id', $userId)->where('item_id', $stockId)->exists();
    }

    // StockモデルとUserモデルの多対多の関係を定義（リレーション設定）
    // belongsToMany（モデルクラス名、中間テーブル名、外部キー、関連づけるモデルの外部キー）
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }
}
