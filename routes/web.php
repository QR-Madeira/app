<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttractionsAdminController;
use App\Http\Controllers\AttractionLocationsController;
use App\Http\Controllers\GalleryAdminController;
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

/*
  Exemplo de como as urls funcionam agora:

  /
  /{attraction name}

  /admin                        
  /admin/list/attractions
  /admin/create/attraction
  /admin/edit/attraction/{id}
  /admin/delete/attraction/{id}

  Exemplo de como as rotas funcionam agora:
     route('list.attraction')
  route('creator.attraction')
   route('create.attraction')
     route('edit.attraction')
   route('update.attraction')
   route('delete.attraction')

*/

Route::name('admin.')->middleware([Authenticate::class])->group(function () {

  Route::prefix('admin')->group(function(){

    Route::prefix('list')->group(function(){
      // Pages
      Route::get('/attraction', [AttractionsAdminController::class, 'list'])->name('list.attraction');
    });

    Route::prefix('create')->group(function(){
      // Pages
      Route::get('/attraction', [AttractionsAdminController::class, 'creator'])->name('creator.attraction');

      // Actions
      Route::post('/attraction', [AttractionsAdminController::class, 'create'])->name('create.attraction');
      Route::post('/gallery/image', [GalleryAdminController::class, 'create'])->name('create.image');
    });
    
    Route::prefix('edit')->group(function(){
      // Pages
      Route::get('/attraction/{id}', [AttractionsAdminController::class, 'updater'])->name('edit.attraction');
      Route::get('/gallery/{id}', [GalleryAdminController::class, 'list'])->name('edit.attraction.gallery');
    });
    
    Route::prefix('update')->group(function(){
      // Actions
      Route::put('/attraction/{id}', [AttractionsAdminController::class, 'update'])->name('update.attraction');
    });

    Route::prefix('delete')->group(function(){
      // Actions
      Route::get('/attraction/{id}', [AttractionsAdminController::class, 'delete'])->name('delete.attraction');
      Route::get('/image/{id}', [GalleryAdminController::class, 'delete'])->name('delete.image');
    });

    /* Users */

      /* Pages */
        Route::get('/list_users', [UsersAdminController::class, 'list'])->name('list_users');
        Route::get('/create_user', [UsersAdminController::class, 'creator'])->name('creator_user');
      /* //Pages */

      /* Actions */
        Route::post('/create_user', [UsersAdminController::class, 'create'])->name('create_user');
        Route::get('/delete_user/{id}', [UsersAdminController::class, 'delete'])->name('delete_user');
      /* //Actions */

    /* //Users */

    /* Locations */

      /* Pages */
        Route::get('/create_location/{id}', [AttractionLocationsController::class, 'creator'])->name('creator_location');
      /* //Pages */

      /* Actions */
        Route::put('/update_location/{id}', [AttractionLocationsController::class, 'update'])->name('update_location');
        Route::post('/create_location/{id}', [AttractionLocationsController::class, 'create'])->name('create_location');
        Route::get('/delete_location/{id}', [AttractionLocationsController::class, 'delete'])->name('delete_location');
      /* //Actions */

    /* //Locations */

    });
});

Route::get('/login', [SessionController::class, 'index'])->name('login');
Route::post('/signin', [SessionController::class, 'signin'])->name('signin');
Route::get('/signout', [SessionController::class, 'signout'])->name('signout');

Route::get('/', function () {
  return view('viewer.index');
})->name('index');

Route::get('/{title_compiled}', [AttractionsViewerController::class, 'index'])->name('view');
Route::get('/{title_compiled}/gallery', [AttractionsViewerController::class, 'gallery'])->name('view.gallery');
Route::get('/{title_compiled}/map', [AttractionsViewerController::class, 'map'])->name('view.map');

Route::get('/greeting/{locale}', function (string $locale) {
  if (! in_array($locale, ['en', 'pt'])) {
    abort(400);
  }
  app()->setLocale($locale);
  session()->put('locale', $locale);
  return redirect()->back();
})->name('language');
