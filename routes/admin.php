<?php
use Illuminate\Support\Facades\Route;

Route::resources([
    'shop-product' => ShopProductController::class,
]);
