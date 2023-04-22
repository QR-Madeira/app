<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttractionsAdminController;
use App\Http\Controllers\AttractionsViewerController;
use App\Http\Controllers\SessionController;

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

Route::name('admin.')->group(function(){

  Route::prefix('admin')->group(function(){

    Route::get('/create', [AttractionsAdminController::class, 'creator'])->name('creator');

    Route::post('/create', [AttractionsAdminController::class, 'create'])->name('create');
  
    Route::get('/delete/{id}', [AttractionsAdminController::class, 'delete'])->name('delete');
  
    Route::get('/list', [AttractionsAdminController::class, 'list'])->name('list');

    Route::get('/login', [SessionController::class, 'index'])->name('login');

    Route::post('/signin', [SessionController::class, 'signin'])->name('signin');
    Route::post('/signout', [SessionController::class, 'signout'])->name('signout');
  
  });
  
});

Route::get('/{title_compiled}', [AttractionsViewerController::class, 'index'])->name('view');
