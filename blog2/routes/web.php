<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function(){
    return "Bonjour les gens";
});

Route::get('/welcome/{name}', function($name){
    return "Welcome $name";
});

Route::prefix('admin')->group(function () {
    Route::get('home', function () {
        return 'Bienvenue sur l\'accueil';
    });
});