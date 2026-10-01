<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Dictionary\AppInfoController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\QuizImportController;

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

Route::get('/', [App\Http\Controllers\AdminController::class, 'login_check'])->name('admin.login_check');

Route::get('/api',[App\Http\Controllers\Api\ApiController::class,'check']);


Route::get('auth/login', function () {
    return view('auth.login');
});

Route::get('add-to-log', 'App\Http\Controllers\HomeController@myTestAddToLog');


Route::group(['prefix' => 'admin'], function(){
	Route::group(['middleware' => 'admin.guest'], function() {
		Route::view('/login','admin.login')->name('admin.login');
		Route::post('/login',[App\Http\Controllers\AdminController::class, 'authenticate'])->name('admin.auth');
	});

	Route::group(['middleware' => 'admin.auth'], function() {

        Route::get('/dashboard', [App\Http\Controllers\AdminController::class,'dashboard'])->name('admin/dashboard');

        Route::get('/admin_add_app', [App\Http\Controllers\AppController::class,'Add_list']);


        //profile update
        Route::get('/profile_update', function () {return view('admin.accounts.profile_update');});

        Route::any('/home','App\Http\Controllers\AdminController@profileUpdate')->name('profileupdate');

        Route::post('/uploadFile', 'App\Http\Controllers\CategoryController@uploadFile');



        //question

        Route::post('/image_upload', [App\Http\Controllers\PrayerController::class, 'upload'])->name('upload');

        //Accounts list

        Route::get('/superadmin',[App\Http\Controllers\AdminController::class,'superadmin'])->name('superadmin');

        Route::get('/admin_add_sub_admin',[App\Http\Controllers\AdminController::class,'add']);

        Route::post('/admin_insert',[App\Http\Controllers\AdminController::class,'insert']);

        Route::any('/edit_admin/{id}',[App\Http\Controllers\AdminController::class,'edit']);

        Route::any('/edit_admin_list/{id}',[App\Http\Controllers\AdminController::class,'editlist']);

        Route::post('/user_status_update', [App\Http\Controllers\AdminController::class, 'active']);

        Route::post('/delete_admin/{id}',[App\Http\Controllers\AdminController::class,'delete']);

        Route::get('/logActivity', 'App\Http\Controllers\HomeController@logActivity');

        Route::post('/activitydelete',[App\Http\Controllers\AdminController::class,'activitydelete']);

        route::post('/manage/{id}',[App\Http\Controllers\AdminController::class,'manage']);

        Route::get('/import',[App\Http\Controllers\Dictionary\DictionaryImportController::class,'dictionary_import'])->name('import.list');


        //AppInfos List
        Route::get('/apps_list',[App\Http\Controllers\Dictionary\AppInfoController::class,'show'])->name('apps.list');

        Route::get('/add_apps', [App\Http\Controllers\Dictionary\AppInfoController::class,'Add_list']);

        Route::post('/apps.insert', [App\Http\Controllers\Dictionary\AppInfoController::class,'store'])->name('apps.insert');

        Route::post('/edit_apps_list/{id}',[App\Http\Controllers\Dictionary\AppInfoController::class,'EditCatList']);

        Route::any('/edit_apps/{id}',[App\Http\Controllers\Dictionary\AppInfoController::class,'EditCategory'])->name('admin.apps.edit');

        Route::post('/delete_apps/{id}',[App\Http\Controllers\Dictionary\AppInfoController::class,'delete'])->name('admin.apps.delete');

        Route::post('/apps_status_update', [App\Http\Controllers\Dictionary\AppInfoController::class, 'active'])->name('admin.apps.status_update');


        //dictionarys List

        Route::get('/dictionary_list',[App\Http\Controllers\Dictionary\DictionaryInfoController::class,'show'])->name('dictionary.list');

        Route::get('/add_dictionary', [App\Http\Controllers\Dictionary\DictionaryInfoController::class,'Add_list']);

        Route::post('/dictionary.insert', [App\Http\Controllers\Dictionary\DictionaryInfoController::class,'store'])->name('dictionary.insert');

        Route::post('/edit_dictionary_list/{id}',[App\Http\Controllers\Dictionary\DictionaryInfoController::class,'EditCatList']);

        Route::any('/edit_dictionary/{id}',[App\Http\Controllers\Dictionary\DictionaryInfoController::class,'EditCategory']);

        Route::post('/delete_dictionary/{id}',[App\Http\Controllers\Dictionary\DictionaryInfoController::class,'delete']);

        Route::post('/dictionary_status_update', [App\Http\Controllers\Dictionary\DictionaryInfoController::class, 'active']);

        Route::post('/dictionary/import', [App\Http\Controllers\Dictionary\DictionaryImportController::class, 'import'])->name('dictionary.import');

        
        //books List

        Route::get('/book_list',[App\Http\Controllers\Book\BookInfoController::class,'show'])->name('book.list');

        Route::get('/add_book', [App\Http\Controllers\Book\BookInfoController::class,'Add_list']);

        Route::post('/book.insert', [App\Http\Controllers\Book\BookInfoController::class,'store'])->name('book.insert');

        Route::post('/edit_book_list/{id}',[App\Http\Controllers\Book\BookInfoController::class,'EditCatList']);

        Route::any('/edit_book/{id}',[App\Http\Controllers\Book\BookInfoController::class,'EditCategory']);

        Route::post('/delete_book/{id}',[App\Http\Controllers\Book\BookInfoController::class,'delete']);

        Route::post('/book_status_update', [App\Http\Controllers\Book\BookInfoController::class, 'active']);

        Route::post('/book/import', [App\Http\Controllers\Book\BookImportController::class, 'import'])->name('book.import');
        
        Route::get('/book_import',[App\Http\Controllers\Book\BookImportController::class,'book_import'])->name('book_import.list');

        
        //verses List

        Route::get('/verse_list',[App\Http\Controllers\Verse\VerseInfoController::class,'show'])->name('verse.list');

        Route::get('/add_verse', [App\Http\Controllers\Verse\VerseInfoController::class,'Add_list']);

        Route::post('/verse.insert', [App\Http\Controllers\Verse\VerseInfoController::class,'store'])->name('verse.insert');

        Route::post('/edit_verse_list/{id}',[App\Http\Controllers\Verse\VerseInfoController::class,'EditCatList']);

        Route::any('/edit_verse/{id}',[App\Http\Controllers\Verse\VerseInfoController::class,'EditCategory']);

        Route::post('/delete_verse/{id}',[App\Http\Controllers\Verse\VerseInfoController::class,'delete']);

        Route::post('/verse_status_update', [App\Http\Controllers\Verse\VerseInfoController::class, 'active']);

        Route::post('/verse/import', [App\Http\Controllers\Verse\VerseImportController::class, 'import'])->name('verse.import');
        
        Route::get('/verses/import/status', [App\Http\Controllers\Verse\VerseImportController::class, 'getImportProgress'])->name('admin.verses.import.status');

        Route::get('/verse_import',[App\Http\Controllers\Verse\VerseImportController::class,'verse_import'])->name('verse_import.list');
        
        
        //versions List

        Route::get('/version_list',[App\Http\Controllers\Version\VersionInfoController::class,'show'])->name('version.list');

        Route::get('/add_version', [App\Http\Controllers\Version\VersionInfoController::class,'Add_list']);

        Route::post('/version.insert', [App\Http\Controllers\Version\VersionInfoController::class,'store'])->name('version.insert');

        Route::post('/edit_version_list/{id}',[App\Http\Controllers\Version\VersionInfoController::class,'EditCatList']);

        Route::any('/edit_version/{id}',[App\Http\Controllers\Version\VersionInfoController::class,'EditCategory']);

        Route::post('/delete_version/{id}',[App\Http\Controllers\Version\VersionInfoController::class,'delete']);

        Route::post('/version_status_update', [App\Http\Controllers\Version\VersionInfoController::class, 'active']);

        Route::post('/version/import', [App\Http\Controllers\Version\VersionImportController::class, 'import'])->name('version.import');
        
        Route::get('/version_import',[App\Http\Controllers\Version\VersionImportController::class,'version_import'])->name('version_import.list');
        
        //templates List

        Route::get('/template_list',[App\Http\Controllers\Dictionary\TemplateInfoController::class,'show'])->name('template.list');

        Route::get('/add_template', [App\Http\Controllers\Dictionary\TemplateInfoController::class,'Add_list']);

        Route::post('/template.insert', [App\Http\Controllers\Dictionary\TemplateInfoController::class,'store'])->name('template.insert');

        Route::post('/edit_template_list/{id}',[App\Http\Controllers\Dictionary\TemplateInfoController::class,'EditCatList']);

        Route::any('/edit_template/{id}',[App\Http\Controllers\Dictionary\TemplateInfoController::class,'EditCategory']);

        Route::post('/delete_template/{id}',[App\Http\Controllers\Dictionary\TemplateInfoController::class,'delete']);

        Route::post('/template_status_update', [App\Http\Controllers\Dictionary\TemplateInfoController::class, 'active']);

        Route::post('/template/import', [App\Http\Controllers\Dictionary\TemplateImportController::class, 'import'])->name('template.import');
        
        Route::get('/template_import',[App\Http\Controllers\Dictionary\TemplateImportController::class,'template_import'])->name('template_import.list');


        // Support Controller
        Route::post('/getaudiotype', [App\Http\Controllers\SupportController::class, 'GetAudioType'])->name('admin.getaudiotype');
        
        // Display job status page
        Route::get('/job-status', [App\Http\Controllers\JobStatusController::class, 'showStatus'])->name('job.status');
        
        // API endpoint for AJAX polling
        Route::get('/job-status/api', [App\Http\Controllers\JobStatusController::class, 'getStatusApi'])->name('job.status.api');
        
        // Start job endpoint
        Route::post('/job-status/start', [App\Http\Controllers\JobStatusController::class, 'startJob'])->name('job.start');
        
        // Reset job endpoint
        Route::post('/job-status/reset', [App\Http\Controllers\JobStatusController::class, 'resetJob'])->name('job.reset');
        
        // Stop job endpoint
        Route::post('/job-status/stop', [App\Http\Controllers\JobStatusController::class, 'stopJob'])->name('job.stop');
        
        // Get job logs endpoint
        Route::get('/job-status/logs', [App\Http\Controllers\JobStatusController::class, 'getJobLogs'])->name('job.logs');
            
        Route::post('/clear-log', function() {
            file_put_contents(storage_path('logs/laravel.log'), '');
            return response()->json(['success' => true]);
        });
        
    });

    Route::get('/get-books', [App\Http\Controllers\SupportController::class, 'getBooks'])->name('get.books'); // AJAX call route

    Route::get('/get-bible_chapters', [App\Http\Controllers\SupportController::class, 'getChapters'])->name('get.bible_chapters'); // AJAX call route

    Route::get('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
});

//Notification List
Route::group(['middleware' => 'admin.auth'], function() {
    // Mark all as read
    Route::post('/notifications/mark-all-read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    });
    
    // Mark single as read
    Route::post('/notifications/{notification}/mark-as-read', function($notificationId) {
        $notification = auth()->user()->notifications()->where('id', $notificationId)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    });
    
    // Delete notification
    Route::delete('/notifications/{notification}/delete', function($notificationId) {
        $notification = auth()->user()->notifications()->where('id', $notificationId)->first();
        if ($notification) {
            $notification->delete();
        }
        return response()->json(['success' => true]);
    });
});
