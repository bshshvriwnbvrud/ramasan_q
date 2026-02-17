<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\WinnerController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileRequestController;
use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\AttemptController;
use App\Http\Controllers\Student\LeaderboardController;
use App\Http\Controllers\Student\WelcomeController;
use App\Http\Controllers\Student\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('landing'))->name('landing');
Route::view('/about', 'pages.about')->name('about');
Route::view('/instructions', 'pages.instructions')->name('instructions');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Account Status Pages (for students pending/rejected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/account/pending', fn() => view('account.pending'))->name('account.pending');
    Route::get('/account/rejected', fn() => view('account.rejected'))->name('account.rejected');
});

/*
|--------------------------------------------------------------------------
| Student Routes (must be authenticated and approved)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('student.welcome');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('student.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('student.profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('student.profile.update');

    // Attempts
    Route::post('/competitions/{competition}/start', [AttemptController::class, 'start'])
        ->name('attempt.start')
        ->whereNumber('competition');
    Route::get('/attempts/{attempt}', [AttemptController::class, 'show'])
        ->name('attempt.show')
        ->whereNumber('attempt');
    Route::post('/attempts/{attempt}/answer', [AttemptController::class, 'answer'])
        ->name('attempt.answer')
        ->whereNumber('attempt');
    Route::get('/attempts/{attempt}/result', [AttemptController::class, 'result'])
        ->name('attempt.result')
        ->whereNumber('attempt');

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('student.leaderboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (full access, only admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Users (full CRUD)
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('admin.users.show');
    Route::post('/users/{user}/approve', [UserManagementController::class, 'approve'])->name('admin.users.approve');
    Route::post('/users/{user}/reject', [UserManagementController::class, 'reject'])->name('admin.users.reject');

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('admin.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    // Competitions
    Route::get('/competitions', [CompetitionController::class, 'index'])->name('admin.competitions');
    Route::get('/competitions/create', [CompetitionController::class, 'create'])->name('admin.competitions.create');
    Route::post('/competitions', [CompetitionController::class, 'store'])->name('admin.competitions.store');
    Route::get('/competitions/{competition}/edit', [CompetitionController::class, 'edit'])
        ->name('admin.competitions.edit')
        ->whereNumber('competition');
    Route::put('/competitions/{competition}', [CompetitionController::class, 'update'])
        ->name('admin.competitions.update')
        ->whereNumber('competition');
    Route::post('/competitions/{competition}/toggle', [CompetitionController::class, 'toggle'])
        ->name('admin.competitions.toggle')
        ->whereNumber('competition');

    // Questions
    Route::get('/questions', [QuestionController::class, 'index'])->name('admin.questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('admin.questions.store');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('admin.questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('admin.questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('admin.questions.destroy');
    Route::get('/questions/import', [QuestionController::class, 'importForm'])->name('admin.questions.import.form');
    Route::post('/questions/import', [QuestionController::class, 'import'])->name('admin.questions.import');
    Route::get('/questions/export', [QuestionController::class, 'export'])->name('admin.questions.export');
    Route::get('/questions/import-to-competition', [QuestionController::class, 'importToCompetitionForm'])
        ->name('admin.questions.import_to_competition.form');
    Route::post('/questions/import-to-competition', [QuestionController::class, 'importToCompetition'])
        ->name('admin.questions.import_to_competition');

    // Winners
    Route::get('/competitions/{competition}/winners', [WinnerController::class, 'index'])
        ->name('admin.competitions.winners.index')
        ->whereNumber('competition');
    Route::get('/competitions/{competition}/winners/select', [WinnerController::class, 'select'])
        ->name('admin.competitions.winners.select')
        ->whereNumber('competition');
    Route::post('/competitions/{competition}/winners', [WinnerController::class, 'store'])
        ->name('admin.competitions.winners.store')
        ->whereNumber('competition');
    Route::post('/competitions/{competition}/winners/publish', [WinnerController::class, 'publish'])
        ->name('admin.competitions.winners.publish')
        ->whereNumber('competition');

    // Profile edit requests
    Route::get('/profile-requests', [ProfileRequestController::class, 'index'])->name('admin.profile_requests.index');
    Route::get('/profile-requests/{profileRequest}', [ProfileRequestController::class, 'show'])
        ->name('admin.profile_requests.show')
        ->whereNumber('profileRequest');
    Route::post('/profile-requests/{profileRequest}/approve', [ProfileRequestController::class, 'approve'])
        ->name('admin.profile_requests.approve')
        ->whereNumber('profileRequest');
    Route::post('/profile-requests/{profileRequest}/reject', [ProfileRequestController::class, 'reject'])
        ->name('admin.profile_requests.reject')
        ->whereNumber('profileRequest');

    // Activity log
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('admin.activity_log.index');

    // Reset attempt for a user
    Route::post('/competitions/{competition}/reset-attempt/{user}', [AttemptController::class, 'resetForUser'])
        ->name('admin.competitions.reset_attempt')
        ->whereNumber(['competition', 'user']);
});

/*
|--------------------------------------------------------------------------
| Supervisor Routes (view only, cannot modify)
|--------------------------------------------------------------------------
*/
Route::prefix('supervisor')->middleware(['auth', 'role:supervisor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('supervisor.dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('supervisor.users');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('supervisor.users.show');
    Route::get('/competitions', [CompetitionController::class, 'index'])->name('supervisor.competitions');
    Route::get('/competitions/{competition}/winners', [WinnerController::class, 'index'])
        ->name('supervisor.competitions.winners.index');
    Route::get('/profile-requests', [ProfileRequestController::class, 'index'])->name('supervisor.profile_requests.index');
    Route::get('/profile-requests/{profileRequest}', [ProfileRequestController::class, 'show'])
        ->name('supervisor.profile_requests.show');
});

/*
|--------------------------------------------------------------------------
| Editor Routes (manage questions only)
|--------------------------------------------------------------------------
*/
Route::prefix('editor')->middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/questions', [QuestionController::class, 'index'])->name('editor.questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('editor.questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('editor.questions.store');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('editor.questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('editor.questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('editor.questions.destroy');
    Route::get('/questions/import', [QuestionController::class, 'importForm'])->name('editor.questions.import.form');
    Route::post('/questions/import', [QuestionController::class, 'import'])->name('editor.questions.import');
    Route::get('/questions/export', [QuestionController::class, 'export'])->name('editor.questions.export');
});