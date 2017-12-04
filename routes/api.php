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
    Route::get('edit-details/{id}', 'API\PassportController@editDetails');
    Route::post('update-details/{id}', 'API\PassportController@updateDetails');
    Route::get('delete-details/{id}', 'API\PassportController@deleteDetails');
    Route::get('status-details/{id}/{status}', 'API\PassportController@statusDetails'); //enable and disable
    Route::get('get-countries', 'API\ExploreController@getCountryList');

    // consumers
    Route::get('get-consumer', 'API\ConsumerController@index');
    Route::post('insert-consumer', 'API\ConsumerController@insertConsumer');
    Route::get('view-consumer', 'API\ConsumerController@viewConsumer');
    Route::get('edit-consumer/{id}','API\ConsumerController@editConsumer');
    Route::post('update-consumer/{id}','API\ConsumerController@updateConsumer');
    Route::get('delete-consumer/{id}','API\ConsumerController@deleteConsumer');
    Route::get('status-consumer/{id}/{status}','API\ConsumerController@statusConsumer');
    Route::post('consumer-module','API\ConsumerController@consumerModule');


    // explore menu
    Route::post('add-explore', 'API\ExploreController@add');
    Route::get('get-explore', 'API\ExploreController@index');
    Route::post('update-explore/{id}', 'API\ExploreController@updateRecord');
    Route::get('get-explore/{id}/edit', 'API\ExploreController@edit');
    Route::delete('delete-explore/{id}', 'API\ExploreController@delete');

    /**
    * for modules
    */
    Route::post('add-module','API\ModuleController@addModule');
    Route::get('view-module','API\ModuleController@viewModule');
    Route::get('get-module/{id}','API\ModuleController@getModule');
    Route::post('update-module/{id}','API\ModuleController@updateModule');
    Route::get('delete-module/{id}','API\ModuleController@deleteModule');

    /**
    * for roles
    */
    Route::post('insert-role','API\RoleController@insertRole');
    Route::get('view-role','API\RoleController@viewRoles');
    Route::get('edit-role/{id}','API\RoleController@editRole');
    Route::post('update-role/{id}','API\RoleController@updateRole');
    Route::get('delete-role/{id}','API\RoleController@deleteRole');
    Route::get('status-role/{id}/{status}','API\RoleController@statusRole');

    /**
    * for authors
    */
    Route::post('insert-author','API\AuthorController@insertAuthor');
    Route::get('view-author','API\AuthorController@viewAuthor');
    Route::get('edit-author/{id}','API\AuthorController@editAuthor');
    Route::post('update-author/{id}','API\AuthorController@updateAuthor');
    Route::get('delete-author/{id}','API\AuthorController@deleteAuthor');

    /**
    * for category
    */
    Route::post('insert-category','API\CategoryController@insertCategory');
    Route::get('view-category','API\CategoryController@viewCategory');
    Route::get('edit-category/{id}','API\CategoryController@editCategory');
    Route::post('update-category/{id}','API\CategoryController@updateCategory');
    Route::get('delete-category/{id}','API\CategoryController@deleteCategory');
    Route::get('status-category/{id}/{status}','API\CategoryController@statusCategory');

    /**
    * for keywords
    */
    Route::post('insert-keyword','API\KeywordController@insertKeyword');
    Route::get('view-keyword','API\KeywordController@viewKeyword');
    Route::get('edit-keyword/{id}','API\KeywordController@editKeyword');
    Route::post('update-keyword/{id}','API\KeywordController@updateKeyword');
    Route::get('delete-keyword/{id}','API\KeywordController@deleteKeyword');

    /**
    * for authorizers
    */
    Route::post('insert-authorizer', 'API\AuthorizerController@insertAuthorizer');
    Route::get('view-authorizers', 'API\AuthorizerController@viewAuthorizers');
    Route::get('edit-authorizer/{id}', 'API\AuthorizerController@editAuthorizer');
    Route::post('update-authorizer/{id}', 'API\AuthorizerController@updateAuthorizer');
    Route::get('delete-authorizer', 'API\AuthorizerController@deleteAuthorizer');


});
