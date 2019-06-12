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
// socialite laravel  
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');
// end socialite
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/settings', 'HomeController@settings')->name('settings')->middleware('role:Administrateur');
Route::post('/settings', 'HomeController@update_settings')->name('settings.update')->middleware('role:Administrateur');
Route::get('/profile/settings', 'HomeController@profileSettings')->name('settings.profile'); 

Route::resource('users', 'UserController');

Route::resource('authenticationLogs', 'AuthenticationLogController')->middleware('role:Administrateur');

Route::resource('pages', 'PageController');



// api facebook  test  

Route::group(['middleware' => [
    'auth'
]], function(){

    Route::get('/user', 'GraphController@retrieveUserProfile'); // success test 
    Route::get('/user/post','GraphController@publishToProfile');
    Route::get('/user/page', 'GraphController@publishToPage');
    Route::get('/user/page/create', 'GraphController@createPage');
});
// end test 

Route::resource('posts', 'PostController');
Route::get('posts/create/{id}', 'PostController@create')->name('posts.create1');

Route::resource('comments', 'CommentController');
Route::get('comments/create/{id}', 'CommentController@create')->name('comments.create1');