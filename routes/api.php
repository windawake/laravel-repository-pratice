<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Request;

if(App::environment('local')){
    Route::prefix('frontend')->group(function () {
        require_once __DIR__."/local/frontend.php";
    });

    Route::prefix('backend')->group(function () {
        require_once __DIR__."/local/backend.php";
    });
}else{
    Route::prefix('frontend')->group(function () {
        require_once __DIR__."/api/frontend.php";
    });
    
    Route::prefix('backend')->group(function () {
        require_once __DIR__."/api/backend.php";
    });
}
