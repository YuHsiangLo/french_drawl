<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ConsentFormController;
use App\Http\Controllers\DemographicQuestionnaireController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\StartPageController;
use App\Http\Controllers\WelcomePageController;



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
Route::get('/',[StartPageController::class, 'index'])->name('startpage.index');
Route::get('/welcome/{locale}',[WelcomePageController::class, 'show'])->name('welcome.show');
Route::get('/consent_forms/create',[ConsentFormController::class, 'create'])->name('consent_forms.create');
Route::post('/consent_forms',[ConsentFormController::class, 'store'])->name('consent_forms.store');
Route::get('/demographic_questionnaires/create',[DemographicQuestionnaireController::class, 'create'])->name('demographic_questionnaires.create');
Route::post('/demographic_questionnaires',[DemographicQuestionnaireController::class, 'store'])->name('demographic_questionnaires.store');
Route::get('/recordings/create',[RecordingController::class, 'create'])->name('recordings.create');
Route::post('/recordings',[RecordingController::class, 'store'])->name('recordings.store');
Route::get('/map',[MapController::class, 'show'])->name('map.show');

Auth::routes();

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin_users', [AdminUserController::class, 'index'])->name('admin_users.index');
Route::get('/admin_users/{user_id}/authorize', [AdminUserController::class, 'authorizeUser'])->name('admin_users.authorize');
Route::get('/admin_users/{user_id}/deauthorize', [AdminUserController::class, 'deauthorizeUser'])->name('admin_users.deauthorize');
Route::get('/admin_users/{user_id}/destroy', [AdminUserController::class, 'destroy'])->name('admin_users.destroy');

Route::get('/consent_forms', [ConsentFormController::class, 'index'])->name('consent_forms.index')->middleware('auth');
Route::get('/consent_forms/{id}',[ConsentFormController::class, 'show'])->name('consent_forms.show')->middleware('auth');
Route::get('/consent_forms/{id}/destroy',[ConsentFormController::class, 'destroy'])->name('consent_forms.destroy-get')->middleware('auth');
Route::get('/demographic_questionnaires/{id}/destroy',[DemographicQuestionnaireController::class, 'destroy'])->name('demographic_questionnaires.destroy-get')->middleware('auth');
Route::get('/recordings/{id}/destroy',[RecordingController::class, 'destroy'])->name('recordings.destroy-get')->middleware('auth');

Route::get('/storage/{file_name}', FileController::class)->where(['file_name' => '.*']);

Route::get('/export/consent_forms', [ConsentFormController::class, 'export'])->name('consent_forms.export')->middleware('auth');
Route::get('/download/{id}/recording',[ConsentFormController::class, 'download_recording'])->name('consent_forms.download_recording')->middleware('auth');
//Route::get('/download/recordings', [ConsentFormController::class, 'download_all_recordings'])->name('consent_forms.download_all_recordings')->middleware('auth');

Route::get('/deploy', [DeployController::class, 'deploy']);