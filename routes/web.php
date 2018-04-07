<?php
use Illuminate\Support\Facades\Route;

Route::resources([
    'product' => ProductController::class,
]);
