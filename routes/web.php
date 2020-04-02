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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();
Route::group(['middleware'=>'auth'], function(){
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('skill', 'SkillController');
	Route::get('skills', 'SkillController@getAllSkills')->name('getSkills');
	Route::get('profile', 'UserController@edit')->name('user.profile'); 
	Route::post('prifile-image-upload', 'UserController@updateProfileImage')->name('updateProfileImage'); 

	Route::match(['put', 'patch'],'skill-update/{id}', 'UserController@update')->name('user.skill.update'); 
	Route::post('friend-request-send', 'FriendController@requestSend')->name('friend.request-send'); 
	Route::post('request-status-update', 'FriendController@requestStatusUpdate')->name('friend.request-status-update'); 
	Route::post('request-unfriend', 'FriendController@unfriend')->name('friend.unfriend'); 
	Route::get('friend-request-recived', 'FriendController@newRequestGet')->name('friend.newRequestGet'); 
	Route::get('my-sended-requests', 'FriendController@mySendRequests')->name('friend.mySendedRequests'); 
	Route::get('my-friends', 'FriendController@myFriends')->name('friend.myFriends'); 


});