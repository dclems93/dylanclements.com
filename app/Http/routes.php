<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::group(['middleware' => ['web']], function(){
//});
	
Route::get('/', [
	'uses' => 'PostController@getWelcome',
	'as' => 'welcome'
	]);

Route::get('/#aboutme', [
	'uses' => 'PostController@getWelcome',
	'as' => 'aboutme'
	]);

Route::get('/#recentposts', [
	'uses' => 'PostController@getWelcome',
	'as' => 'recentposts'
	]);

Route::get('/userlogin', function(){
	return view('userlogin');
})->name('userlogin');

Route::get('/blog',[
    'uses' => 'PostController@getBlog',
    'as' => 'blog'
]);

Route::get('projects', [
    'uses' => 'ProjectController@getProjects',
    'as' => 'projects'
]);

Route::get('project/{project_id}', [
    'uses' => 'ProjectController@getProject',
    'as' => 'get.project'
]);

Route::get('/logout',[
	'uses' => 'UserController@getLogout',
	'as' => 'logout'
	]);

Route::get('/account', [
	'uses' => 'UserController@getAccount',
	'as' => 'account'
	]);

Route::get('/profile', [
	'uses' => 'UserController@getUserProfile',
	'as' => 'profile'
	]);

Route::post('/updateaccount', [
	'uses' => 'UserController@postSaveAccount',
	'as' => 'account.save'
	]);

Route::get('/userimage/{filename}', [
	'uses' => 'UserController@getUserImage' ,
	'as' => 'account.image'
	]);

Route::post('/signin',[
	'uses' => 'UserController@postSignIn',
	'as' => 'signin'
	]);

Route::post('/signup', [
    'uses' => 'UserController@postSignUp',
    'as' => 'signup'
]);

Route::get('/forum',[
	'uses' => 'PostController@getForum',
	'as' => 'forum',
	'middleware' => 'auth'
	]);

Route::get('/admin',[
	'uses' => 'UserController@getAdmin',
	'as' => 'admin',
	'middleware' => 'roles',
	'roles' => ['Admin']
	]);

Route::post('/createpost',[
	'uses' => 'PostController@postCreatePost',
	'as' => 'post.create',
	'middleware' => 'auth'
	]);
Route::post('/createproject',[
    'uses' => 'ProjectController@postCreateProject',
    'as' => 'project.create',
    'middleware' => 'auth'
]);

Route::post('/createcomment',[
	'uses' => 'PostController@postCreateComment',
	'as' => 'comment.create',
	'middleware' => 'auth'
	]);

Route::get('/delete-post/{post_id}', [
	'uses' => 'PostController@getDeletePost',
	'as' => 'post.delete',
	'middleware' => 'auth'
	]);

Route::get('/delete-post-welcome/{post_id}', [
	'uses' => 'PostController@getDeletePostWelcome',
	'as' => 'post.deletewelcome',
	'middleware' => 'auth'
	]);

Route::post('/edit', [
	'uses' => 'PostController@postEditPost',
	'as' => 'edit'
	]);

Route::post('/like', [
	'uses' => 'PostController@postLikePost',
	'as' => 'like'
	]);
