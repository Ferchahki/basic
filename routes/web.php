<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Carbon\Carbon;

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
/*
Controller Resources Category
 */
Route::get('/category/all',[CategoryController::class,'AllCat'])->name('category.all');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('category.store');
Route::get('/category/edit/{id}',[CategoryController::class, 'Edit'])->name('category.edit');
Route::post('/category/update/{id}',[CategoryController::class, 'Update']);
Route::get('/softdelete/category/{id}',[CategoryController::class, 'SoftDelete']);
Route::get('/category/restore/{id}',[CategoryController::class, 'Restore']);

Route::get('/brand/all',[BrandController::class,'index'])->name('brand.index');
Route::post('/brand/add', [BrandController::class, 'create'])->name('brand.store');



Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {


    Route::get('/dashboard', function () {$users=User::all();return view('dashboard',compact('users'));})->name('dashboard');


});
