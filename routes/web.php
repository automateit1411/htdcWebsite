<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentApplicationController;
use App\Http\Controllers\TeacherApplicationController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/founder', [PageController::class, 'founder'])->name('founder');
Route::get('/principal', [PageController::class, 'principal'])->name('principal');
Route::get('/principle-list', [PageController::class, 'principalList'])->name('principal.list');
Route::get('/principle-list/{index}', [PageController::class, 'principalDetail'])->name('principal.detail');
Route::get('/vice-principle-list', [PageController::class, 'vicePrincipalList'])->name('vicePrincipal.list');
Route::get('/vice-principle-list/{index}', [PageController::class, 'vicePrincipalDetail'])->name('vicePrincipal.detail');
Route::get('/ex-teacher-list', [PageController::class, 'exTeacherList'])->name('exTeacher.list');
Route::get('/ex-teacher-list/{index}', [PageController::class, 'exTeacherDetail'])->name('exTeacher.detail');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/notices', [PageController::class, 'notices'])->name('notices');
Route::get('/form-downloads', [PageController::class, 'formDownloads'])->name('form-downloads');
Route::get('/teacher-vacant-posts', [PageController::class, 'teacherVacantPosts'])->name('teacher-vacant-posts');
Route::get('/staff-vacant-posts', [PageController::class, 'staffVacantPosts'])->name('staff-vacant-posts');
Route::get('/teacher-information', [PageController::class, 'teacherInformation'])->name('teacher.information');
Route::get('/teacher-information/{index}', [PageController::class, 'teacherInformationDetail'])->name('teacher.information.detail');
Route::get('/teachers-panel', [PageController::class, 'teacherPanel'])->name('teacher.panel');
Route::get('/daily-attendance', [PageController::class, 'attendance'])->name('attendance');
Route::get('/feedback', [PageController::class, 'feedback'])->name('feedback');
Route::post('/feedback', [PageController::class, 'sendFeedback'])->name('feedback.send');
Route::get('/useful-links', [PageController::class, 'usefulLinks'])->name('useful-links');
Route::get('/pages/{id}', [PageController::class, 'showCustomPage'])->name('custom.page');

// Custom Page 2 Public Route
Route::get('/p2/{slug}', [PageController::class, 'customPage2'])->name('custom-page2.show');

// Staff Routes
Route::get('/staff-information', [PageController::class, 'staffInformation'])->name('staff.information');
Route::get('/staff-information/{index}', [PageController::class, 'staffInformationDetail'])->name('staff.information.detail');
Route::get('/staff-panel', [PageController::class, 'staffPanel'])->name('staff.panel');

// Employee Login Route
Route::get('/accounts/login/employee', [PageController::class, 'employeeLogin'])->name('employee.login');

// Student Application Routes
Route::get('/apply', [StudentApplicationController::class, 'create'])->name('apply');
Route::post('/apply', [StudentApplicationController::class, 'store'])->name('applications.store');
Route::get('/applications/{application}', [StudentApplicationController::class, 'show'])->name('applications.show');
Route::get('/applications/{application}/download', [StudentApplicationController::class, 'download'])->name('applications.download');

// API Proxy Routes to avoid CORS
Route::get('/proxy/groups/{programId}', [StudentApplicationController::class, 'proxyGroups']);
Route::get('/proxy/subjects/{programId}/{groupId}', [StudentApplicationController::class, 'proxySubjects']);
Route::get('/proxy/employees/{type}', [PageController::class, 'proxyEmployees']);

// Admission API Proxy Routes
Route::get('/proxy/programs', function () {
    $data = app(\App\Services\ExternalApiService::class)->getPrograms();
    return response()->json($data);
});
Route::get('/proxy/sessions', function () {
    $data = app(\App\Services\ExternalApiService::class)->getAdmissionSessions();
    return response()->json($data);
});
Route::get('/proxy/occupations', function () {
    $data = app(\App\Services\ExternalApiService::class)->getOccupations();
    return response()->json($data);
});
Route::get('/proxy/qualifications', function () {
    $data = app(\App\Services\ExternalApiService::class)->getQualifications();
    return response()->json($data);
});
Route::get('/proxy/districts', function () {
    $data = app(\App\Services\ExternalApiService::class)->getDistricts();
    return response()->json($data);
});
Route::get('/proxy/boards', function () {
    $data = app(\App\Services\ExternalApiService::class)->getBoards();
    return response()->json($data);
});
Route::get('/proxy/constants', function () {
    $data = app(\App\Services\ExternalApiService::class)->getConstants();
    return response()->json($data);
});

// Teacher Application Routes
Route::get('/teacher/apply', [TeacherApplicationController::class, 'create'])->name('teacher.apply');
Route::post('/teacher/apply', [TeacherApplicationController::class, 'store'])->name('teacher-applications.store');
Route::get('/teacher/applications/{application}', [TeacherApplicationController::class, 'show'])->name('teacher-applications.show');
Route::get('/teacher/applications/{application}/download', [TeacherApplicationController::class, 'download'])->name('teacher-applications.download');

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SettingController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomPageController;
use App\Http\Controllers\Admin\CustomPage2Controller;
use App\Http\Controllers\Admin\FormDownloadController;
use App\Http\Controllers\Admin\TeacherVacantPostController;
use App\Http\Controllers\Admin\StaffVacantPostController;
use App\Http\Controllers\Admin\WebsiteLinkController;
use App\Http\Controllers\Admin\DailyAttendanceController;
use App\Http\Controllers\Admin\SuperAdminAuthController;
use App\Http\Controllers\Admin\DatabaseExportController;

// Super Admin Routes
Route::get('/super-admin/login', [SuperAdminAuthController::class, 'showLogin'])->name('super-admin.login');
Route::post('/super-admin/login', [SuperAdminAuthController::class, 'login'])->name('super-admin.login.submit');
Route::get('/super-admin/otp', [SuperAdminAuthController::class, 'showOtp'])->name('super-admin.otp');
Route::post('/super-admin/otp/verify', [SuperAdminAuthController::class, 'verifyOtp'])->name('super-admin.otp.verify');
Route::post('/super-admin/logout', [SuperAdminAuthController::class, 'logout'])->name('super-admin.logout');

Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'single.session'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Admin only routes
    Route::middleware(['role:1'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('applications/bulk-delete', [\App\Http\Controllers\Admin\ApplicationController::class, 'bulkDestroy'])->name('applications.bulk-delete');
    });

    // Super Admin only routes
    Route::middleware(['super.admin'])->group(function () {
        Route::get('database-export', [DatabaseExportController::class, 'index'])->name('database-export.index');
        Route::get('database-export/{table}/download', [DatabaseExportController::class, 'download'])->name('database-export.download');
        Route::get('database-export/download-all', [DatabaseExportController::class, 'downloadAll'])->name('database-export.download-all');
        Route::get('database-export/media/download-all', [DatabaseExportController::class, 'downloadAllMedia'])->name('database-export.media.download-all');
        Route::get('database-export/media/{folder}/download', [DatabaseExportController::class, 'downloadMedia'])->name('database-export.media.download');
    });

    // Admin and Editor routes
    Route::middleware(['role:1,2'])->group(function () {
        Route::resource('notices', NoticeController::class)->except(['index', 'show']);
        Route::resource('form-downloads', FormDownloadController::class)->except(['index', 'show']);
        Route::resource('teacher-vacant-posts', TeacherVacantPostController::class)->except(['index', 'show']);
        Route::resource('staff-vacant-posts', StaffVacantPostController::class)->except(['index', 'show']);
        Route::resource('galleries', GalleryController::class)->except(['index', 'show']);
        Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class)->except(['index', 'show']);
        Route::patch('/sliders/{slider}/toggle-status', [\App\Http\Controllers\Admin\SliderController::class, 'toggleStatus'])->name('sliders.toggle-status');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::get('custom-pages/{custom_page}/settings', [CustomPageController::class, 'settings'])->name('custom-pages.settings');
        Route::put('custom-pages/{custom_page}/update-settings', [CustomPageController::class, 'updateSettings'])->name('custom-pages.update-settings');
        Route::resource('custom-pages', CustomPageController::class);

        // Website Links
        Route::resource('website-links', WebsiteLinkController::class);
        Route::patch('website-links/{websiteLink}/toggle-status', [WebsiteLinkController::class, 'toggleStatus'])->name('website-links.toggle-status');

        // Custom Page 2 Routes
        Route::get('custom-page2', [CustomPage2Controller::class, 'index'])->name('custom-page2.index');
        Route::get('custom-page2/create', [CustomPage2Controller::class, 'create'])->name('custom-page2.create');
        Route::post('custom-page2', [CustomPage2Controller::class, 'store'])->name('custom-page2.store');
        Route::get('custom-page2/{custom_page2}/edit', [CustomPage2Controller::class, 'edit'])->name('custom-page2.edit');
        Route::put('custom-page2/{custom_page2}', [CustomPage2Controller::class, 'update'])->name('custom-page2.update');
        Route::delete('custom-page2/{custom_page2}', [CustomPage2Controller::class, 'destroy'])->name('custom-page2.destroy');
        Route::get('custom-page2/{custom_page2}/items', [CustomPage2Controller::class, 'items'])->name('custom-page2.items');
        Route::post('custom-page2/{custom_page2}/items', [CustomPage2Controller::class, 'storeItem'])->name('custom-page2.store-item');
        Route::delete('custom-page2/{custom_page2}/items/{item}', [CustomPage2Controller::class, 'destroyItem'])->name('custom-page2.destroy-item');

        // Daily Attendance Routes
        Route::get('daily-attendances/bulk-create', [DailyAttendanceController::class, 'bulkCreate'])->name('daily-attendances.bulk-create');
        Route::post('daily-attendances/bulk-store', [DailyAttendanceController::class, 'bulkStore'])->name('daily-attendances.bulk-store');
        Route::resource('daily-attendances', DailyAttendanceController::class);
    });

    // View routes (Admin, Editor, and Viewer)
    Route::middleware(['role:1,2,3'])->group(function () {
        Route::resource('notices', NoticeController::class)->only(['index', 'show']);
        Route::resource('form-downloads', FormDownloadController::class)->only(['index', 'show']);
        Route::resource('teacher-vacant-posts', TeacherVacantPostController::class)->only(['index', 'show']);
        Route::resource('staff-vacant-posts', StaffVacantPostController::class)->only(['index', 'show']);
        Route::resource('teacher-applications', \App\Http\Controllers\Admin\TeacherApplicationController::class);
        Route::resource('applications', \App\Http\Controllers\Admin\ApplicationController::class);
        Route::resource('galleries', GalleryController::class)->only(['index', 'show']);
        Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class)->only(['index', 'show']);
    });
});

// Dynamic Pages for Departments, Facilities, and Core Pages (MUST BE LAST - catch-all)
$dynamicPages = [
    'about', 'at-a-glance', 'bou',
    'science', 'business-studies', 'humanities',
    'accounting', 'management', 'economics',
    'ba', 'bbs', 'bss',
    'digital-content', 'multimedia-classroom', 'central-library',
    'ict-lab', 'wifi', 'rover-scout', 'bncc', 'red-crescent', 'science-lab',
    'governing-board', 'testimonial-tc'
];

Route::get('/{slug}', [PageController::class, 'dynamicPage'])->name('dynamic.page');
