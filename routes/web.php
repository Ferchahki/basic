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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');



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
/*
Controller Resources Brand
 */
Route::get('/brand/all',[BrandController::class,'index'])->name('brand.index');
Route::post('/brand/add', [BrandController::class, 'store'])->name('brand.store');
Route::get('/brand/edit/{id}',[BrandController::class, 'Edit'])->name('brand.edit');
Route::post('/brand/update/{id}',[BrandController::class, 'Update']);
Route::get('/softdelete/brand/{id}',[BrandController::class, 'SoftDelete']);

/*
Controller Resources MultiPicture
 */

 Route::get('/multipic/image',[BrandController::class,'Multipic'])->name('multipic.image');
 Route::post('/multipic/add',[BrandController::class,'StoreImage'])->name('multipic.store');


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {


    Route::get('/dashboard', function () {

        //$users=User::all();
        //return view('dashboard',compact('users'));
        return view('admin.index');

    })->name('dashboard');

});

Route::post('/user/logout', [BrandController::class, 'Logout'])->name('user.logout');


