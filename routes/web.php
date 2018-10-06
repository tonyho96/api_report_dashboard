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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/pdf', 'PdfController@index');

Route::get('/test', 'MailChimpController@index');
Route::get('/test-data', 'MailChimpController@test');
Route::get('/cron/sync-reports-for-oldest-user', 'CronController@syncReportsForOldestUser');
Route::get('/cron/sync-oldest-reports', 'CronController@syncOldestReports');
//Dashboard
Route::group( [ 'prefix'=>'/dashboard', 'middleware' => 'auth' ], function () {
	Route::get('/', 'DashboardController@index')->name('dashboard');
	Route::get('/report/{campaign_id}', 'DashboardController@showReport')->name('report');
	Route::get('/report/{campaign_id}/click-reports-members', 'DashboardController@showClickReportsMembers');
    Route::get('/report/{campaign_id}/contact-list', 'DashboardController@showContactList')->name('contact-list');
    Route::resource('users', 'UserController')->middleware('auth');
	Route::get('/download/report/{campaign_id}', 'DashboardController@downloadReport')->name('downloadreport');
    Route::get('/profile', 'DashboardController@showProfile')->name('profile');
	Route::post('/profile', 'DashboardController@saveProfile')->name('saveprofile');
	Route::get('/report/{campaign_id}/activity-reports-detail', 'DashboardController@showActivityReport');
});
