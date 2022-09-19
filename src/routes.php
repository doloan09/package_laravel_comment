<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

Route::post('comments', Config::get('comments.controller') . '@store')->name('comments.store');
Route::delete('comments/{comment}', Config::get('comments.controller') . '@destroy')->name('comments.destroy');
Route::put('comments/{comment}', Config::get('comments.controller') . '@update')->name('comments.update');
Route::post('comments/{comment}', Config::get('comments.controller') . '@reply')->name('comments.reply');

Route::post('likes', Config::get('likes.controller') . '@store')->name('likes.store');
Route::get('likes/{id_comment}/{id_user}', Config::get('likes.controller') . '@getLike')->name('likes.getLike'); //
Route::get('sum-likes/{id_comment}', Config::get('likes.controller') . '@getSumLike')->name('likes.getSumLike'); //
Route::get('list-liker/{id_comment}', Config::get('likes.controller') . '@getListLiker')->name('likes.getListLiker'); //
Route::delete('likes/{id_comment}', Config::get('likes.controller') . '@destroy')->name('likes.destroy');
