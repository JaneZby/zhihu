<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//运行 php artisan make:auth 后产生  Auth::routes();
Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('email/verify/{token}',
    [
    'as' => 'email.verify',
    'uses' => 'EmailController@verify',
    ]
);
Route::resource('questions', 'QuestionsController', ['names' => [
        'create' => 'question.create',
        'show' => 'question.show'
    ]
]);

