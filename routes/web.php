<?php

use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Auth;
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
Route::middleware('checkAdmin')->prefix("admin")
    ->as("admin.")
    ->group(function () {
        //Giao diện chính admin
        Route::get("/", [DashboardController::class, 'index'])->name("dashboard");
        //Route with profile
        Route::prefix('profile')
            ->as("profile.")
            ->group(function () {
            Route::get("/", [ProfileController::class, 'index'])->name("index");
            Route::get("edit", [ProfileController::class, 'edit'])->name("edit");
            Route::put("update", [ProfileController::class, 'update'])->name("update");


        });
        //Route with products
        Route::prefix("products")
            ->as("products.")
            ->group(function () {
            //Tạo dữ liệu mẫu những bản xunh quanh bảng products
            Route::get("/", [ProductController::class, 'index'])->name("index");
            Route::get("create", [ProductController::class, 'create'])->name("create");
            Route::post("store", [ProductController::class, 'store'])->name("store");
            Route::get("edit/{product}", [ProductController::class, 'edit'])->name("edit");
            Route::put("update/{product}", [ProductController::class, 'update'])->name("update");
            Route::get("destroy/{product}", [ProductController::class, 'destroy'])->name("destroy");
            //Route with catalogues
            Route::prefix("catalogues")
                ->as("catalogues.")
                ->group(function () {
                Route::get("/", [CatalogController::class, 'index'])->name("index");
                Route::get("create", [CatalogController::class, 'create'])->name("create");
                Route::post("store", [CatalogController::class, 'store'])->name("store");
                Route::get("show/{catalogue}", [CatalogController::class, 'show'])->name("show");
                Route::get("edit/{catalogue}", [CatalogController::class, 'edit'])->name("edit");
                Route::put("update/{catalogue}", [CatalogController::class, 'update'])->name("update");
                Route::get("delete/{catalogue}", [CatalogController::class, 'delete'])->name("delete");
                Route::get("restore/{id}", [CatalogController::class, 'restore'])->name("restore");
            });
        });
    });
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
