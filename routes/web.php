<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\ProfileInteractionController;
use App\Http\Controllers\RecoveryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('home');
Route::get('/login', function() { return redirect()->route('home'); })->name('login');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); // Fallback for manual entry

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/about', [ProfileController::class, 'editAbout'])->name('profile.about');
    Route::post('/profile/about', [ProfileController::class, 'updateAbout'])->name('profile.about.update');
    Route::delete('/profile/photo/{index}', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::get('/plans', [ProfileController::class, 'plans'])->name('plans');
    Route::post('/upgrade', [AuthController::class, 'upgrade'])->name('upgrade');
    Route::get('/interests', [InterestController::class, 'index'])->name('interests.index');
    Route::post('/interests/{interest}', [InterestController::class, 'update'])->name('interests.update');
    Route::delete('/interests/{interest}', [InterestController::class, 'destroy'])->name('interests.destroy');
    Route::post('/send-interest', [InterestController::class, 'send'])->name('interest.send');
    
    // Interaction Routes
    Route::post('/like/{user}', [ProfileInteractionController::class, 'toggleLike'])->name('profile.like');
    Route::get('/liked-me', [ProfileInteractionController::class, 'getLikes'])->name('profile.liked-me');
    Route::post('/track-view/{user}', [ProfileInteractionController::class, 'trackView'])->name('profile.track-view');
    Route::get('/visitors', [ProfileInteractionController::class, 'getVisitors'])->name('profile.visitors');
    Route::get('/api/notifications', [ProfileInteractionController::class, 'getNotifications']);
    Route::post('/api/notifications/mark-read', [ProfileInteractionController::class, 'markNotificationsRead']);
    
    // Chat Routes
    Route::get('/chat/{user?}', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/{user}/send', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{user}/fetch', [\App\Http\Controllers\ChatController::class, 'fetchMessages'])->name('chat.fetch');
    // Account Deletion
    Route::post('/profile/delete-request', [\App\Http\Controllers\AccountDeletionController::class, 'requestDeletion'])->name('profile.delete.request');
    Route::post('/profile/delete-confirm', [\App\Http\Controllers\AccountDeletionController::class, 'confirmDeletion'])->name('profile.delete.confirm');
    Route::post('/profile/recover', [\App\Http\Controllers\AccountDeletionController::class, 'recoverAccount'])->name('profile.recover');
});

Route::get('/p/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('/api/chatbot', [\App\Http\Controllers\PageController::class, 'chatbotAnswer'])->name('api.chatbot');

// Admin Auth (Accessible without admin middleware)
Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login.submit');

// Recovery Routes
// Route::get('/forgot-email', [RecoveryController::class, 'showForgotEmail'])->name('forgot-email');
// Route::post('/forgot-email', [RecoveryController::class, 'findEmail'])->name('forgot-email.submit');
// Route::get('/verify-email-otp', [RecoveryController::class, 'showVerifyEmailOtp'])->name('forgot-email.verify');
// Route::post('/verify-email-otp', [RecoveryController::class, 'verifyEmailOtp'])->name('forgot-email.verify.submit');

Route::get('/forgot-password', [RecoveryController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [RecoveryController::class, 'sendResetOtp'])->name('password.email');
Route::get('/verify-reset-otp', [RecoveryController::class, 'showVerifyOtp'])->name('password.verify.otp');
Route::post('/reset-password', [RecoveryController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::post('/users/{user}/update', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/settings', [\App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
    Route::get('/legal', [\App\Http\Controllers\AdminController::class, 'legal'])->name('legal');
    Route::post('/settings', [\App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Stories
    Route::get('/stories', [\App\Http\Controllers\AdminController::class, 'stories'])->name('stories');
    Route::get('/stories/create', [\App\Http\Controllers\AdminController::class, 'createStory'])->name('stories.create');
    Route::post('/stories', [\App\Http\Controllers\AdminController::class, 'storeStory'])->name('stories.store');
    Route::delete('/stories/{story}', [\App\Http\Controllers\AdminController::class, 'deleteStory'])->name('stories.delete');

    // FAQs
    Route::get('/faqs', [\App\Http\Controllers\AdminController::class, 'faqs'])->name('faqs');
    Route::post('/faqs', [\App\Http\Controllers\AdminController::class, 'storeFaq'])->name('faqs.store');
    Route::delete('/faqs/{faq}', [\App\Http\Controllers\AdminController::class, 'deleteFaq'])->name('faqs.delete');

    // System Logs
    Route::get('/logs', [\App\Http\Controllers\AdminController::class, 'viewLogs'])->name('logs');

    // Verifications
    Route::get('/verifications', [\App\Http\Controllers\AdminController::class, 'verifications'])->name('verifications');
    Route::post('/verifications/{profile}/approve', [\App\Http\Controllers\AdminController::class, 'approveVerification'])->name('verifications.approve');
    Route::post('/verifications/{profile}/reject', [\App\Http\Controllers\AdminController::class, 'rejectVerification'])->name('verifications.reject');
});
