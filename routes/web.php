<?php

use \Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('cloud/{category}/{file}/{size1}x{size2}', function ($category, $file, $size1 = 100, $size2 = 100)
{
    if (Storage::disk('public')->exists($category.'/'.$file)) {
        return Image::make(storage_path('app/public/'.$category.'/'.$file))->resize($size1, $size2)->response();
    }

    return Image::make(storage_path('app/public/images/default.png'))->resize($size1, $size2)->response();
});

Route::get('/{vue}', 'VueController@index')->where('vue', '.*');