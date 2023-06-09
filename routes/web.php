<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AttractionsAdminController;
use App\Http\Controllers\AttractionLocationsController;
use App\Http\Controllers\GalleryAdminController;
use App\Http\Controllers\AttractionsViewerController;
use App\Http\Controllers\UsersAdminController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Socials;
use App\Http\Controllers\Verification;
use App\Http\Middleware\Authenticate;
use App\Models\Site;
use Illuminate\Support\Facades\App;

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
  /admin/update/attraction/{id}
  /admin/delete/attraction/{id}

  Exemplo de como as rotas funcionam agora:
     route("list.attraction")
  route("creator.attraction")
   route("create.attraction")
     route("edit.attraction")
   route("update.attraction")
   route("delete.attraction")

*/

Route::name("admin.")->middleware([Authenticate::class])->group(function () {

    Route::prefix("admin")->group(function () {

        Route::prefix("list")->group(function () {
            // Pages
            Route::get("/attraction", [AttractionsAdminController::class, "list"])->name("list.attraction");
            Route::get("/users", [UsersAdminController::class, "list"])->name("list.users");
        });

        Route::prefix("create")->group(function () {
            // Pages
            Route::get("/attraction", [AttractionsAdminController::class, "creator"])->name("creator.attraction");
            Route::get("/user", [UsersAdminController::class, "creator"])->name("creator.user");
            Route::get("/location/{id}", [AttractionLocationsController::class, "creator"])->name("creator.location");

            // Actions
            Route::post("/attraction", [AttractionsAdminController::class, "create"])->name("create.attraction");
            Route::post("/gallery/image", [GalleryAdminController::class, "create"])->name("create.image");
            Route::post("/user", [UsersAdminController::class, "create"])->name("create.user");
            Route::post("/location/{id}", [AttractionLocationsController::class, "create"])->name("create.location");
        });

        Route::prefix("edit")->group(function () {
            // Pages
            Route::get("/siteInfo", [SiteController::class, "updater"])->name("edit.site");
            Route::get("/user/{id}", [UsersAdminController::class, "updater"])->name("edit.user");
            Route::get("/user_pass/{id}", [UsersAdminController::class, "pass_updater"])->name("edit.user_pass");
            Route::get("/attraction/{id}", [AttractionsAdminController::class, "updater"])->name("edit.attraction");
            Route::get("/location/{id}/{id_2}", [AttractionLocationsController::class, "updater"])->name("edit.location");
            Route::get("/gallery/{id}", [GalleryAdminController::class, "list"])->name("edit.attraction.gallery");
        });

        Route::prefix("update")->group(function () {
            // Actions
            Route::put("/siteInfo", [SiteController::class, "update"])->name("update.site");
            Route::put("/user/{id}", [UsersAdminController::class, "create"])->name("update.user");
            Route::put("/user_pass/{id}", [UsersAdminController::class, "update_pass"])->name("update.user_pass");
            Route::put("/attraction/{id}", [AttractionsAdminController::class, "update"])->name("update.attraction");
            Route::put("/location/{id}/{id_2}", [AttractionLocationsController::class, "create"])->name("update.location");
        });

        Route::prefix("delete")->group(function () {
            // Actions
            Route::get("/attraction/{id}", [AttractionsAdminController::class, "delete"])->name("delete.attraction");
            Route::get("/image/{id}", [GalleryAdminController::class, "delete"])->name("delete.image");
            Route::get("/user/{id}", [UsersAdminController::class, "delete"])->name("delete.user");
            Route::get("/location/{id}/{id_2}", [AttractionLocationsController::class, "delete"])->name("delete.location");
        });

        Route::get("/main", [AdminController::class, "main"])->name("main");

        Route::any("/site/socials/{id?}", Socials::index(...))->name("site_socials");
    });
});

Route::get("/login", [SessionController::class, "index"])->name("login");
Route::post("/signin", [SessionController::class, "signin"])->name("signin");
Route::get("/signout", [SessionController::class, "signout"])->name("signout");

Route::any("/forgor", Verification::forgor(...))->name("forgor");
Route::any("/verify", Verification::index(...))->name("verify");

Route::get("/", function () {
    $siteInfo = Site::first();

    $socials = $siteInfo->socials()->get();

    $desc = $siteInfo->desc->where("language", App::currentLocale())->first() ?? $siteInfo->desc->first();

    $desc = $desc?->description ?? "";
    $siteInfo = $siteInfo->toArray();
    $siteInfo["desc"] = $desc;

    $siteInfo["socials"] = $socials;
    return view("viewer.index", ["siteInfo" => $siteInfo]);
})->name("index");

Route::get("/{title_compiled}", [AttractionsViewerController::class, "index"])->name("view");
Route::get("/{title_compiled}/gallery", [AttractionsViewerController::class, "gallery"])->name("view.gallery");
Route::get("/{title_compiled}/map", [AttractionsViewerController::class, "map"])->name("view.map");

Route::get("/greeting/{locale}", function (string $locale) {
    if (!in_array($locale, ["en", "pt"])) {
        abort(400);
    }
    app()->setLocale($locale);
    session()->put("locale", $locale);
    return redirect()->back();
})->name("language");
