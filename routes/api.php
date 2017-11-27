<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');



Route::group(['middleware' => 'auth:api'], function(){
	Route::get('get-details', 'API\PassportController@getDetails');
    Route::get('get-countries', 'API\ExploreController@getCountryList');

    // consumers
    Route::get('get-consumer', 'API\ConsumerController@index');

    // explore menu
    Route::post('add-explore', 'API\ExploreController@add');
    Route::get('get-explore', 'API\ExploreController@index');
    Route::post('update-explore/{id}', 'API\ExploreController@updateRecord');
    Route::get('get-explore/{id}/edit', 'API\ExploreController@edit');
    Route::delete('delete-explore/{id}', 'API\ExploreController@delete');

    //for modules
    Route::post('add-module','API\ModuleController@addModule');
    Route::post('update-module','API\ModuleController@updateModule');
    Route::get('view-module','API\ModuleController@viewModule');
    Route::post('delete-module','API\ModuleController@deleteModule');

    //for roles
    Route::post('insert-role','API\RoleController@insertRole');
    Route::get('view-role','API\RoleController@viewRoles');
    Route::post('update-role','API\RoleController@updateRole');
    Route::post('delete-role','API\RoleController@deleteRole');
    Route::post('update-status','API\RoleController@updateStatus');

    //for author
    Route::post('insert-author','API\AuthorController@insertAuthor');
    Route::get('view-author','API\AuthorController@viewAuthor');
    Route::post('update-author','API\AuthorController@updateAuthor');
    Route::post('delete-author','API\AuthorController@deleteAuthor');

    //for category
    Route::post('insert-category','API\CategoryController@insertCategory');
    Route::get('view-category','API\CategoryController@viewCategory');
    Route::post('update-category','API\CategoryController@updateCategory');
    Route::post('delete-category','API\CategoryController@deleteCategory');

    //for keywords
    Route::post('insert-keyword','API\KeywordController@insertKeyword');
    Route::get('view-keyword','API\KeywordController@viewKeyword');
    Route::post('update-keyword','API\KeywordController@updateKeyword');
    Route::post('delete-keyword','API\KeywordController@deleteKeyword');

});