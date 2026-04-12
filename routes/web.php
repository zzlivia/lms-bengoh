<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Admin\CommunityStoryController;
use App\Http\Controllers\Admin\CommunityStoryController as AdminCommunityStoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\LectureSectionController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\Admin\CourseAssAdminController;
use App\Http\Controllers\AssessmentController;
use Illuminate\Support\Facades\Mail;


Route::get('/run-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations executed!';
});

Route::get('/test-auth', function () {
    return auth()->check() ? 'LOGGED IN' : 'NOT LOGGED IN';
});

/* public route */

Route::get('/', fn () => view('homepage'));
Route::get('/homepage', fn () => view('homepage'))->name('homepage');
Route::get('/lang/{lang}', function ($lang) {
        if (in_array($lang, ['en', 'ms', 'iban', 'biatah'])) {
            session(['locale' => $lang]);
        }
        return redirect()->back();
    })->name('lang.switch');

/* authentication */

Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthenticationController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthenticationController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthenticationController::class, 'showForgotPassword'])
    ->name('password.request');

Route::post('/forgot-password', [AuthenticationController::class, 'requestReset'])
    ->name('password.sendTemp');

Route::get('/test-mail', function () {
    Mail::raw('Test email from Laravel', function ($message) {
        $message->to('geemajovinus@gmail.com')
                ->subject('Test Email');
    });

    return 'Email sent!';
});

Route::get('/check-mail', function () {
    return config('mail.mailers.smtp.password');
});

/* courses */
Route::get('/courses', [CourseController::class, 'allCourses'])->name('courses.allCourses');
Route::get('/courses/{id}', [CourseController::class, 'showCourse'])->name('courses.showCourse');
Route::get('/courses/{id}/startLearn/{sectionId?}', [CourseController::class, 'startLearning'])->name('learn');

/* MCQs */
Route::get('/module/{id}/mcqs', [CourseController::class, 'showMCQS'])->name('mcq.module'); 
Route::post('/module/{id}/submit', [CourseController::class, 'submitMCQS'])->name('module.submit');
Route::get('/module/{id}/review', [CourseController::class, 'reviewMCQ'])->name('module.review');

/* lecture */
Route::post('/lecture/{lectID}/complete', [CourseController::class, 'completeLecture'])->name('lecture.complete');    
Route::post('/lecture/complete-next', [CourseController::class, 'completeAndNext'])->name('lecture.complete.and.next');
Route::post('/lecture/complete/{lectID}', [CourseController::class, 'markComplete']);

Route::middleware(['auth'])->group(function () {
    /* feedback */
    Route::get('/course/{id}/feedback', [CourseController::class, 'courseFeedback'])->name('course.feedback');
    Route::post('/course/{id}/feedback', [CourseController::class, 'submitFeedback'])->name('course.feedback.submit');

    /* course assessment */
    //checks progress
    Route::get('/course/{id}/assessment', [CourseController::class, 'courseAssessment'])->name('course.assessment');
        
    //actual assessment page
    Route::get('/course/{id}/assessment/view', [AssessmentController::class, 'showAssessment'])->name('assessment.show');
        
    Route::post('/assessment/submit', [AssessmentController::class, 'submitAssessment'])->name('assessment.submit');

    Route::post('/course/{id}/final-submit', [CourseController::class, 'submitFinalAssessment'])->name('final.assessment.submit');

    /* progress */
    Route::get('/course/{id}/progress', [CourseController::class, 'showAllProgress'])->name('course.progress');
});
    

/* module and mcqs*/

Route::get('/module/{id}', [ModuleController::class, 'viewModule'])->name('module.viewModule');

Route::get('/module/{id}/quiz', [CourseController::class, 'showQuiz'])->name('module.quiz');

Route::post('/admin/module/toggle/{id}', [CourseAssAdminController::class, 'toggleModule'])->name('admin.module.toggle');

//Route::get('/module/{id}/questions', [CourseController::class, 'showModuleQuestions'])->name('module.questions');
    
Route::post('/module/{id}/questions', [CourseController::class, 'submitModuleQuestions'])->name('module.questions.submit');

Route::get('/module/{id}/start', [CourseController::class, 'startLearning'])->name('module.start');

//mcq preview
Route::get('/mcq/preview/{moduleID}', [ModuleController::class, 'previewMCQ'])->name('mcq.preview');

//edit mcq by module
Route::get('/admin/mcq/edit/{moduleID}', [ModuleController::class, 'editMCQ'])->name('admin.mcq.edit');
    
//enable or disable mcq
Route::post('/admin/mcq/toggle/{moduleID}', [ModuleController::class, 'toggleMCQ'])->name('admin.mcq.toggle');

/* lecture section*/ 
Route::post('/admin/section/store', [LectureSectionController::class,'store'])->name('admin.section.store');

/* leaderboard*/

Route::get('/leaderboards', [CourseController::class, 'leaderboard'])->middleware('auth')->name('course.leaderboard');

/* learner's settings*/

Route::prefix('settings')->name('settings.')->group(function () {

    Route::get('/', function () {return redirect()->route('settings.profile');})->name('index');

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
    
    Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('user.delete');

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

    Route::post('/module/store', [ModuleController::class, 'storeNewModule'])
        ->name('module.store');

    Route::get('/module/edit/{id}', [ModuleController::class, 'editModule'])
        ->name('module.edit');

    Route::delete('/module/delete/{id}', [ModuleController::class, 'deleteModule'])
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
        ->name('section.delete');//delete section

    /* mcqs */
    Route::post('/mcq/store', [ModuleController::class, 'storeMCQ'])->name('mcq.store');

    /* course assessment */

    Route::post('/assessment/store', [CourseAssAdminController::class, 'storeAssessment'])
        ->name('assessment.storeAss');

    Route::get('/assessment/{courseID}', [CourseAssAdminController::class, 'displayAssessment'])
        ->name('assessment.displayAss');
    
    Route::get('/assessment/{id}/questions', [CourseAssAdminController::class, 'addQuestionsPage'])
        ->name('assessment.questions');

    Route::post('/assessment/questions/store', [CourseAssAdminController::class, 'storeQuestions'])
        ->name('assessment.questions.store');

    Route::post('/assessment/store', [CourseAssAdminController::class, 'saveAssessment'])
        ->name('assessment.saveAss');
    
    Route::get('/assessment/{id}/questions', [CourseAssAdminController::class, 'addQuestionsPage'])
        ->name('assessment.addQs');

    Route::post('/assessment/questions/store', [CourseAssAdminController::class, 'storeQuestions']) 
        ->name('assessment.addQs.storeQs');

    Route::get('/assessments', [CourseAssAdminController::class, 'manageAss'])
        ->name('assessment.manageCourseAss');

    Route::get('/assessments/{id}/add-questions', [CourseAssAdminController::class, 'addQuestionsPage'])
        ->name('assessment.addQs');

    Route::delete('/assessment/{id}', [CourseAssAdminController::class, 'deleteAss'])
        ->name('assessment.deleteCourseAss');

    Route::get('/assessment/{id}/edit', [CourseAssAdminController::class, 'editAss'])
        ->name('assessment.editAss');

    Route::put('/assessment/{id}', [CourseAssAdminController::class, 'updateAss'])
        ->name('assessment.updateAss');

    Route::get('/assessment/{id}/questions', [CourseAssAdminController::class, 'showQuestions'])
        ->name('assessment.viewQuestions');

    Route::get('/assessment/{id}/edit-questions', [CourseAssAdminController::class, 'editQuestions'])
        ->name('assessment.editQuestions');

    Route::delete('/question/{id}', [CourseAssAdminController::class, 'deleteQuestion'])
        ->name('assessment.deleteQuestion');

    Route::get('/assessment/{id}/questions', [CourseAssAdminController::class, 'addQuestions'])
        ->name('assessment.addQuestions');

    Route::get('/assessment/{id}/results', [AssessmentController::class, 'viewResults'])->name('assessment.viewResults');

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

    /* feedback */
    
    Route::get('/feedback', [AdminController::class, 'feedbackList'])->name('feedback');

    /* community stories that controlled by admin*/
    Route::get('/stories', [AdminCommunityStoryController::class, 'index'])->name('stories.index');
    Route::get('/stories/create', [AdminCommunityStoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [AdminCommunityStoryController::class, 'store'])->name('stories.store');
    Route::get('/stories/{id}/edit', [AdminCommunityStoryController::class, 'edit'])->name('stories.edit');
    Route::put('/stories/{id}', [AdminCommunityStoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{id}', [AdminCommunityStoryController::class, 'destroy'])->name('stories.destroy');
});
