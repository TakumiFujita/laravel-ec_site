<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'item_id');
    }
}
