<?php

use Livewire\Volt\Volt;
use App\Livewire\Auth\RoleCrud;
use App\Livewire\Auth\UserCrud;
use App\Livewire\QuizComponent;
use App\Livewire\ChapterComponent;
use App\Livewire\MaterialComponent;
use App\Livewire\AssignmentComponent;
use App\Livewire\Auth\PermissionCrud;
use App\Livewire\QuizDetailComponent;
use App\Livewire\SubmissionComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\DescriptionComponent;
use App\Livewire\QuizPublicComponent;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/chapter', ChapterComponent::class)->name('chapter');
Route::get('/chapter/{id}', DescriptionComponent::class)->name('description');
Route::view('/', 'public.landing-page')->name('home');
Route::get('/quiz-public', QuizPublicComponent::class)->name('quiz.public');

Route::get('/score', function () {
    return view('public.score');
})->name('score');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('/permissions', PermissionCrud::class)->name('permissions');
    Route::get('/roles', RoleCrud::class)->name('roles');
    Route::get('/userscrud', UserCrud::class)->name('userscrud');


    Route::get('/material', MaterialComponent::class)->name('material');
    Route::get('/assignment', AssignmentComponent::class)->name('assignment');
    Route::get('/submission', SubmissionComponent::class)->name('submission');
    Route::prefix('quiz')->group(function () {
        Route::get('', QuizComponent::class)->name('quiz');
        Route::get('{quizId}', QuizDetailComponent::class)->name('quiz.detail');
    });



    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
