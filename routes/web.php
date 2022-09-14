<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoController;
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
// memo
route::controller(todoController::class)->group(
    function () {
        route::get('/', 'root')->name('root');
        route::post('/registerCheck', 'registerCheck');
        route::post('/registerSuccess', 'registerSuccess');
        route::post('/loginCheck', 'loginCheck');
        route::post('/loginSuccess', 'loginSuccess');
        route::get('/logout', 'logout');
    }
);

route::controller(todoController::class)->middleware('login')->group(
    function () {
        route::get('home', 'home')->name('home');
        route::post('home/addItem', 'addItem');
        route::post('home/changeItem', 'changeItem');

        route::get('/mypage', 'mypage')->name('mypage');
        route::post('/changePass', 'changePass');
    }
);
