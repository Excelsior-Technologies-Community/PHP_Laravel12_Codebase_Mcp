<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);

Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
Route::post('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
