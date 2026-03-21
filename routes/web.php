<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Admin\CommunityStoryController;
use App\Http\Controllers\Admin\CommunityStoryController as AdminCommunityStoryController;
//use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\LectureSectionController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminSettingsController;

/* public route */

Route::get('/', fn () => view('homepage'));
Route::get('/homepage', fn () => view('homepage'))->name('homepage');

/* authentication */

Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthenticationController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthenticationController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

/* courses */

Route::get('/courses', [CourseController::class, 'allCourses'])->name('courses.allCourses');
Route::get('/courses/{id}', [CourseController::class, 'showCourse'])->name('courses.showCourse');
//Route::get('/courses/{id}/learn', [CourseController::class, 'startLearning'])->name('courses.learn');

/* module and mcqs*/

//Route::get('/module/{id}/quiz', [CourseController::class, 'showQuiz'])->name('module.quiz');

//Route::get('/module/{id}/questions', [CourseController::class, 'showModuleQuestions'])->name('module.questions');
    

//Route::post('/module/{id}/questions', [CourseController::class, 'submitModuleQuestions'])->name('module.questions.submit');
    

/* lecture section*/ 
//Route::post('/admin/section/store', [LectureSectionController::class,'store'])->name('admin.section.store');
    

/* course feedback */

//Route::get('/course/{id}/feedback', [CourseController::class, 'courseFeedback'])->name('course.feedback');
    

//Route::post('/course/feedback', [CourseController::class, 'submitFeedback'])->name('course.feedback.submit');
    

/* course assessment*/

//Route::get('/course/{id}/assessment', [CourseController::class, 'courseAssessment'])->name('course.assessment');
    

/* course progress*/

//Route::get('/course/{course}/progress', [CourseController::class, 'progress']) ->name('course.progress');
   

/* leaderboard*/

//Route::get('/leaderboards', [CourseController::class, 'leaderboard'])->middleware('auth')->name('leaderboards');
    
    

/* learner's settings*/

Route::prefix('settings')->name('settings.')->group(function () {

    Route::get('/', fn () => view('settings.settings'))->name('index');

    Route::get('/notifications', [SettingsController::class, 'notifications'])
        ->name('notifications');

    Route::post('/notifications/save', [SettingsController::class, 'saveNotifications'])
        ->name('notifications.save');

    Route::get('/preferences', [SettingsController::class, 'preferences'])
        ->name('preferences');

    Route::post('/preferences/save', [SettingsController::class, 'savePreferences'])
        ->name('preferences.save');

    Route::middleware('auth')->group(function () {

        Route::get('/profile', [SettingsController::class, 'profile'])
            ->name('profile');

        Route::post('/profile/update', [SettingsController::class, 'updateProfile'])
            ->name('profile.update');

    });
});

/* community stories*/

Route::get('/community-stories', [CommunityStoryController::class, 'index'])
    ->name('community.stories');

/* admin authentication*/

Route::get('/admin/signin', [AuthenticationController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/signin', [AuthenticationController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AuthenticationController::class, 'logout'])
    ->name('admin.logout');

Route::post('/request-reset', [AuthenticationController::class, 'requestReset'])
    ->name('request.reset');

/* admin's management*/
Route::prefix('admin')
    ->middleware('auth:admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/user-management', [AdminController::class, 'userManagement'])
        ->name('user.management');

    Route::get('/course-module-management', [AdminController::class, 'courseModuleManagement'])
        ->name('course.module');

    Route::get('/course-module/create', [AdminController::class, 'createCourseModule'])
        ->name('course.module.create');

    Route::post('/course/store', [AdminController::class, 'storeCourse'])
        ->name('course.store');

    Route::get('/course/edit/{id}', [AdminController::class,'editCourse'])
        ->name('course.edit');

    Route::put('/course/update/{id}', [AdminController::class,'updateCourse'])
        ->name('course.update');

    Route::delete('/course/delete/{id}', [AdminController::class,'deleteCourse'])
        ->name('course.delete');

    /* module management*/

    Route::post('/module/store', [ModuleController::class, 'store'])
        ->name('module.store');

    Route::get('/module/edit/{id}', [ModuleController::class, 'edit'])
        ->name('module.edit');

    Route::delete('/module/delete/{id}', [ModuleController::class, 'delete'])
        ->name('module.delete');

    /* lecture management */

    Route::post('/lecture/store', [ModuleController::class, 'storeLecture'])
        ->name('lecture.store');

    Route::get('/lecture/edit/{id}', [ModuleController::class, 'editLecture'])
        ->name('lecture.edit');

    Route::delete('/lecture/delete/{id}', [ModuleController::class, 'deleteLecture'])
        ->name('lecture.delete');        

    /* lecture section management*/

    
    Route::post('/sections/store', [LectureSectionController::class, 'storeSection'])
        ->name('sections.store');//store section

   
    Route::get('/sections/edit/{id}', [LectureSectionController::class, 'editSection'])
        ->name('sections.edit'); //edit section

    
    Route::put('/sections/update/{id}', [LectureSectionController::class, 'updateSection'])
        ->name('sections.update');//update section

    
    Route::delete('/sections/delete/{id}', [LectureSectionController::class, 'deleteSection'])
        ->name('sections.delete');//delete section

    /* others */

    Route::get('/progress', [AdminController::class, 'progress'])
        ->name('progress');

    Route::get('/announcements', [AdminController::class, 'announcements'])
        ->name('announcements');

    Route::get('/announcements/create', [AdminController::class, 'createAnnouncement'])
        ->name('announcements.create');

    Route::post('/announcements/store', [AdminController::class, 'storeAnnouncement'])
        ->name('announcements.store');

    Route::get('/announcements/{id}/view', [AdminController::class, 'viewAnnouncement'])
        ->name('announcements.view');

    Route::get('/announcements/{id}/review', [AdminController::class, 'reviewAnnouncement'])
        ->name('announcements.review');

    Route::get('/announcements/{id}/edit', [AdminController::class, 'editAnnouncement'])
        ->name('announcements.edit');
    
    Route::put('/announcements/{id}/update', [AdminController::class, 'updateAnnouncement'])
        ->name('announcements.update');

    Route::get('/reports', [AdminController::class, 'reports'])
        ->name('reports');

    Route::get('/report-overview', [AdminController::class, 'reportOverview'])
        ->name('reportOverview');

    Route::get('/download-report', [AdminController::class, 'downloadReport'])
        ->name('downloadReport');

    /*Route::get('/settings', [AdminController::class, 'settings'])
        ->name('settings');*/

    Route::get('/settings', [AdminSettingsController::class,'index'])
        ->name('settings');

    Route::post('/settings/save', [AdminSettingsController::class,'save'])
        ->name('settings.save');

    Route::get('/help-support', [AdminController::class, 'helpSupport'])
        ->name('help');

    Route::get('/password-requests', [AdminController::class, 'passwordRequests'])
        ->name('password.requests');

    
    Route::get('/feedback', [AdminController::class, 'feedback'])
        ->name('feedback');

    /* community stories that controlled by admin*/
    Route::get('/stories', [AdminCommunityStoryController::class, 'index'])->name('stories.index');
    Route::get('/stories/create', [AdminCommunityStoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [AdminCommunityStoryController::class, 'store'])->name('stories.store');
    Route::get('/stories/{id}/edit', [AdminCommunityStoryController::class, 'edit'])->name('stories.edit');
    Route::put('/stories/{id}', [AdminCommunityStoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{id}', [AdminCommunityStoryController::class, 'destroy'])->name('stories.destroy');
});
