<?php

use Illuminate\Support\Facades\Route;


    Route::get('/clear', function () {
        $clearcache = Artisan::call('cache:clear');
        echo "Cache cleared<br>";

        $clearview = Artisan::call('view:clear');
        echo "View cleared<br>";

        $clearconfig = Artisan::call('config:cache');
        echo "Config cleared<br>";
    });


    Route::get('locale/{locale}', function ($locale){
        Session::put('locale', $locale);
        return redirect()->back();
    })->name('locale');


    Route::post('login', 'Auth\LoginController@login')->name('login.submit');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => 'auth'], function() {
        Route::get('dashboard','DashboardController@index')->name('home');
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::get('','DashboardController@index');

        Route::get('student/promote','Modules\StudentController@promote')->name('student.promote');
        Route::post('student/promote','Modules\StudentController@promoteSubmit')->name('student.promote');
        Route::get('student/change_class','Modules\StudentController@changeClass')->name('student.changeClass');
        Route::get('student/change_class/{student}','Modules\StudentController@changeClassForm')->name('student.changeClassForm');
        Route::post('student/change_class/{student}','Modules\StudentController@changeClassFormPost')->name('student.changeClassForm');
        Route::resource('student','Modules\StudentController');

        Route::get('user/parent/assign/{id}','Modules\UserController@parentAssign')->name('parent.assign');
        Route::post('user/parent/assign{id}','Modules\UserController@parentAssignPost')->name('parent.assign.post');
        Route::get('user/change_password','Modules\UserController@password')->name('user.password');
        Route::post('user/change_password','Modules\UserController@passwordPost')->name('user.password.post');
        Route::get('user/password/{id}','Modules\UserController@passwordReset')->name('user.password.change');
        Route::post('user/password/{id}','Modules\UserController@passwordResetPost')->name('user.password.reset');

        Route::resource('user','Modules\UserController');
        Route::resource('books','Modules\BookController');

        Route::resource('class','Modules\ClassController');
        Route::get('class/section/{class_id}','Modules\ClassController@section')->name('class.section');
        Route::get('class/teacher/{class_id}','Modules\ClassController@teacher')->name('class.teacher');
        Route::post('class/teacher/{class_id}','Modules\ClassController@Addteacher')->name('class.teacher.add');

        Route::resource('subject','Modules\SubjectController');
        Route::resource('roles','Modules\RolesController');
        Route::get('permissions', 'Modules\RolesController@permissions')->name('roles.permissions');
        Route::get('assign_role', 'Modules\RolesController@rolesView')->name('roles.assign');
        Route::post('assign_role', 'Modules\RolesController@rolesStore')->name('roles.assign.post');
        Route::resource('notice','Modules\NoticeController');
        Route::resource('message','Modules\MessageController');

        Route::get('fee','Modules\FeeController@index')->name('fee');
        Route::post('fee','Modules\FeeController@update')->name('fee.delete');
        Route::get('fee/collection','Modules\FeeController@collect')->name('fee.collect');
        Route::get('class/fee/status','Modules\FeeController@classFee')->name('class.fee');
        Route::post('class/fee/status','Modules\FeeController@classFeeUpdate')->name('class.fee.update');
        Route::post('fee/collection','Modules\FeeController@store')->name('fee.collect.submit');
        Route::get('fee/type','Modules\FeeController@type')->name('fee.type');
        Route::post('fee/type','Modules\FeeController@typePost')->name('fee.type.post');
        Route::get('fee/owing','Modules\FeeController@owing')->name('fee.owing');
        Route::get('fee/student','Modules\FeeController@student')->name('fee.student');
        Route::get('fee/print','Modules\FeeController@print')->name('fee.print');
        Route::get('fee/report','Modules\FeeController@report')->name('fee.report');
        Route::get('fee/scholarship','Modules\FeeController@scholarship')->name('fee.scholarship');
        Route::post('fee/scholarship','Modules\FeeController@scholarshipSave')->name('fee.scholarship.post');
        Route::get('fee/monthly/report','Modules\FeeController@monthlyReport')->name('fee.monthly.report');
        Route::get('fee/monthly/receipt','Modules\FeeController@monthlyReceipt')->name('fee.monthly.receipt');

        Route::get('fee/scholarship/report','Modules\FeeController@scholarshipReport')->name('fee.scholarship.report');
        Route::get('income','Modules\FeeController@income')->name('fee.income');

        Route::get('expenses','Modules\ExpensesController@index')->name('expenses');
        Route::post('expenses','Modules\ExpensesController@destroy')->name('expenses.destroy');
        Route::get('expenses/new','Modules\ExpensesController@new')->name('expenses.collect');
        Route::post('expenses/new','Modules\ExpensesController@newSubmit')->name('expenses.collect.submit');
        Route::get('expenses/type','Modules\ExpensesController@type')->name('expenses.type');
        Route::post('expenses/type','Modules\ExpensesController@typePost')->name('expenses.type.post');
        Route::get('expenses/{id}','Modules\ExpensesController@edit')->name('expenses.edit');
        Route::post('expenses/{id}','Modules\ExpensesController@update')->name('expenses.update');

        Route::get('setting/session', 'Modules\SettingController@session')->name('settings.session');

        Route::post('setting/session', 'Modules\SettingController@sessionPost')->name('settings.sessionPost');
        Route::get('setting/terms', 'Modules\SettingController@terms')->name('settings.terms');
        Route::get('setting/sequences', 'Modules\SettingController@sequences')->name('settings.sequences');

        Route::post('configure','Modules\SettingController@config')->name('config.set');

        Route::get('pupil/parent', 'Modules\SearchController@pupil')->name('pupil.parent');

        Route::get('result/class', 'Modules\ResultController@class')->name('result.class');
        Route::get('result/class/{class_id}', 'Modules\ResultController@subClass')->name('result.class.sub');
        Route::post('result/class/{class_id}', 'Modules\ResultController@subClass')->name('result.class.sub');
        Route::get('result/student/{class_id}', 'Modules\ResultController@student')->name('result.class.student');
        Route::post('result/edit/{student}', 'Modules\ResultController@editPost')->name('result.edit.post');
        Route::get('result/edit/{student}', 'Modules\ResultController@edit')->name('result.edit');
        Route::get('result/fee_control', 'Modules\ResultController@feeControl')->name('result.fee_control');
        Route::post('result/fee_control', 'Modules\ResultController@feeControlPost')->name('result.fee_control');
        Route::get('result/ranksheet', 'Modules\ResultController@ranksheet')->name('result.ranksheet');
        Route::post('result/{student}', 'Modules\ResultController@resultPost')->name('result.session.post');
        Route::get('result/{student}', 'Modules\ResultController@result')->name('result.session');

        Route::get('import', 'PageController@index');
        Route::post('import', 'PageController@uploadFile')->name('upload.csv');
    });


Route::get('search/student', 'Modules\SearchController@student')->name('search.student');

Route::get('/image/{filename}', 'ImageController@renderImage')->name('image.render');
Route::get('/document/{filename}', 'DocumentController@renderDocument')->name('document.render');
Route::get('print-pdf',  'DocumentController@printPDF');
