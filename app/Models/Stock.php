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

    public function stockDisplay()
    {
        $items = Stock::all();

        return Stock::query();
    }
}
