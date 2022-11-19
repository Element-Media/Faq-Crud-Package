<?php

use Illuminate\Support\Facades\Route;
use Elementcore\Faq\FaqController;

Route::group(['prefix' => 'admin/faq',  'middleware' => 'admin'], function () {
    //-----------------User Admin Routes----------------------- //done
    Route::get('/', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/list', [FaqController::class, 'getFaqList'])->name('faq.list');
    Route::get('/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('/', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
    Route::put('/{id}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
});
