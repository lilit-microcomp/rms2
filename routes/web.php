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
    return view('pages/home');
})->middleware('auth');


Route::get('/', 'HomeController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('projects/get/{id}', 'ProjectsController@getProjects');




Route::resource('tasks','TasksController');
Route::resource('support','SupportController');
Route::resource('thirdparty','ThirdPartyController');
Route::resource('comments','CommentsController');
Route::resource('clients', 'ClientsController');

Route::get('tasks/{id}/user', 'TasksController@userTasks');
Route::post('tasks/{id}/save', 'TasksController@saveComment')->name('tasks.saveComment');
Route::get('support/{id}/user', 'SupportController@userSupport');
Route::post('tasks/{id}', 'TasksController@saveAccessData')->name('tasks.saveAccessData');


Route::post('tasks/setTestUrl/{id}', 'TasksController@setTestUrl')->name('tasks.setTestUrl');



Route::get('home/{task}/finished', 'HomeController@doneTask');
Route::get('/home/{task_comment}/finish-note', 'HomeController@doneNote');
Route::get('/home/{supp_comment}/finish-supp-note', 'HomeController@doneNoteSupp');


Route::get('users/edit_account', 'UsersController@edit_account')->name('users.edit_account');
Route::patch('users/{id}/update_account', 'UsersController@update_account')->name('users.update_account');

Route::post('support/{id}/save', 'SupportController@saveComment')->name('support.saveComment');

//Route::post('tasks/upload/{task}', 'TasksController@fileUpload')->name('file.upload');


Route::get('tasks/{task}/finish-task', 'TasksController@doneTask');
Route::get('supports/{supp}/finish-supp', 'SupportController@doneSupp');
Route::get('projects/{proj}/finish-proj', 'ProjectsController@doneProj');



//////////////Route::post('home/{task}/upload', 'TasksController@fileUpload')->name('file.upload');

Route::post('fileUpload', ['as'=>'fileUpload','uses'=>'TasksController@fileUpload']);
Route::post('fileUploadTaskDash/{task_id}', ['as'=>'fileUploadTaskDash','uses'=>'HomeController@fileUploadTaskDash']);
Route::post('fileUploadSupp', ['as'=>'fileUploadSupp','uses'=>'SupportController@fileUploadSupp']);
Route::post('fileUploadSuppDash/{supp_id}', ['as'=>'fileUploadSuppDash','uses'=>'HomeController@fileUploadSuppDash']);

//Route::post('fileUpload', ['as'=>'fileUpload','uses'=>'HomeController@fileUpload']);
//Route::post('fileUpload/{tasks_id}', 'TasksController@fileUpload')->name('fileUpload');;

//Route::get('/fileUpload/{tasks_id}', 'TasksController@someMethod');

Route::post('fileUploadTaskList/{task_id}', ['as'=>'fileUploadTaskList','uses'=>'TasksController@fileUploadTaskList']);
























Route::group(['middleware' => 'admin'], function () {
//    Route::get('/', 'UsersController@index');
    Route::resource('users','UsersController');
    Route::resource('projects','ProjectsController');


    Route::get('projects/get/{id}', 'ProjectsController@getProjects');


    Route::get('projects/{id}/comments', 'ProjectsController@comments');





});














/*




Route::get('/', function () {
    return view('pages/home');
})->middleware('auth');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('projects/get/{id}', 'ProjectsController@getProjects');




Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {

    Route::get('/', 'UsersController@index');
    Route::resource('users','UsersController');
    Route::resource('projects','ProjectsController');
    Route::resource('tasks','TasksController');
    Route::resource('support','SupportController');
    Route::resource('comments','CommentsController');


    Route::get('projects/get/{id}', 'ProjectsController@getProjects');
    Route::get('tasks/{id}/user', 'TasksController@userTasks');
    Route::post('tasks/{id}/save', 'TasksController@saveComment')->name('tasks.saveComment');
    Route::get('support/{id}/user', 'SupportController@userSupport');

    Route::get('projects/{id}/comments', 'ProjectsController@comments');




    Route::post('tasks/{id}', 'TasksController@saveAccessData')->name('tasks.saveAccessData');


});


Route::group(['middleware' => 'developer'], function () {
    Route::resource('projects','ProjectsController');

    Route::get('projects/get/{id}', 'ProjectsController@getProjects');

    Route::get('projects/{id}/comments', 'ProjectsController@comments');





});

*/































