<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/','StartPageController@index')->name('startpage.index');
Route::get('/welcome/{locale}','WelcomePageController@show')->name('welcome.show');
Route::get('/consent_forms/create','ConsentFormController@create')->name('consent_forms.create');
Route::post('/consent_forms','ConsentFormController@store')->name('consent_forms.store');
Route::get('/demographic_questionnaires/create','DemographicQuestionnaireController@create')->name('demographic_questionnaires.create');
Route::post('/demographic_questionnaires','DemographicQuestionnaireController@store')->name('demographic_questionnaires.store');
Route::get('/recordings/create','RecordingController@create')->name('recordings.create');
Route::post('/recordings','RecordingController@store')->name('recordings.store');
Route::get('/map','MapController@show')->name('map.show');

Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin_users', 'AdminUserController@index')->name('admin_users.index');
Route::get('/admin_users/{user_id}/authorize', 'AdminUserController@authorizeUser')->name('admin_users.authorize');
Route::get('/admin_users/{user_id}/deauthorize', 'AdminUserController@deauthorizeUser')->name('admin_users.deauthorize');
Route::get('/admin_users/{user_id}/destroy', 'AdminUserController@destroy')->name('admin_users.destroy');

Route::get('/consent_forms', 'ConsentFormController@index')->name('consent_forms.index')->middleware('auth');
Route::get('/consent_forms/{id}','ConsentFormController@show')->name('consent_forms.show')->middleware('auth');
Route::get('/consent_forms/{id}/destroy','ConsentFormController@destroy')->name('consent_forms.destroy-get')->middleware('auth');
Route::get('/demographic_questionnaires/{id}/destroy','DemographicQuestionnaireController@destroy')->name('demographic_questionnaires.destroy-get')->middleware('auth');
Route::get('/recordings/{id}/destroy','RecordingController@destroy')->name('recordings.destroy-get')->middleware('auth');

Route::get('/storage/{file_name}', 'FileController')->where(['file_name' => '.*']);

Route::get('/export/consent_forms', 'ConsentFormController@export')->name('consent_forms.export')->middleware('auth');
Route::get('/download/recordings', 'ConsentFormController@download_all_recordings')->name('consent_forms.download_all_recordings')->middleware('auth');

Route::get('/deploy', 'DeployController@deploy');
