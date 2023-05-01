<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttractionsAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttractionsViewerController;
use App\Http\Controllers\UsersAdminController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\Authenticate;

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

Route::name('admin.')->middleware([Authenticate::class])->group(function () {

  Route::prefix('admin')->group(function(){

    Route::get('/create', [AttractionsAdminController::class, 'creator'])->name('creator');
    Route::post('/create', [AttractionsAdminController::class, 'create'])->name('create');
    Route::get('/delete/{id}', [AttractionsAdminController::class, 'delete'])->name('delete');
    Route::get('/list', [AttractionsAdminController::class, 'list'])->name('list');

    Route::get('/list_users', [UsersAdminController::class, 'list'])->name('list_users');
    Route::get('/create_user', [UsersAdminController::class, 'creator'])->name('creator_user');
    Route::post('/create_user', [UsersAdminController::class, 'create'])->name('create_user');
    Route::get('/delete_user/{id}', [UsersAdminController::class, 'delete'])->name('delete_user');

    });
});

Route::get('/login', [SessionController::class, 'index'])->name('login');
Route::post('/signin', [SessionController::class, 'signin'])->name('signin');
Route::get('/signout', [SessionController::class, 'signout'])->name('signout');

Route::get('/', function () {
    return view('viewer.index');
})->name('index');

Route::get('/{title_compiled}', [AttractionsViewerController::class, 'index'])->name('view');

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'pt'])) {
        abort(400);
    }
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language');
