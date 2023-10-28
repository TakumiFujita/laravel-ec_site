<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

//フォールバックルート
Route::fallback(function () {
    return redirect('/index');
});

//商品一覧ページ
Route::get('/index', [ShopController::class, 'index'])->name('shop');
//商品登録ページ
Route::get('/productCreate', [ShopController::class, 'productCreate'])->name('productCreate');
//商品登録
Route::post('/productStore', [ShopController::class, 'productStore'])->name('productStore');
//マイカートのページ
Route::get('/mycart', [ShopController::class, 'myCart'])->name('mycart')->middleware('auth');
//商品をマイカートに追加
Route::post('/addmycart', [ShopController::class, 'addMycart'])->name('addmycart');
//マイカートに追加した商品の削除
Route::delete('/cartdelete', [ShopController::class, 'deleteCart'])->name('cartdelete');
//マイカートに追加した商品の購入
Route::post('/purchase', [ShopController::class, 'purchase'])->name('purchase');
//購入ページをリロード
Route::get('/purchase', [ShopController::class, 'redirect'])->name('shop');
//管理画面の表示
Route::get('/admin', [ShopController::class, 'admin'])->name('admin')->middleware('auth');
//管理画面での商品の削除
Route::delete('/delete/{id}', [ShopController::class, 'itemDelete'])->name('delete');
//管理画面での商品の編集するページ
Route::get('/edit/{id}', [ShopController::class, 'edit'])->name('edit');
//管理画面での商品の更新
Route::get('/update/{stock}', [ShopController::class, 'update'])->name('update');
//権限の付与
Route::put('/roles/{user}/attach', [RoleController::class, 'attach'])->name('role.attach');
//権限を外す
Route::put('/roles/{user}/detach', [RoleController::class, 'detach'])->name('role.detach');
