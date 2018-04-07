<?php
use Illuminate\Support\Facades\Route;

Route::resources([
    'shop-product' => ShopProductController::class,
]);

Route::resources([
    'shop-product-attr' => ShopProductAttrController::class,
]);
