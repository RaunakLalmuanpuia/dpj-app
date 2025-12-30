<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Services\Google\GoogleClientFactory;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google-callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::post('/payment-verify', [App\Http\Controllers\PaymentController::class, 'verifyPayment'])->name('payment.verify');

Route::post('/webhooks/razorpay', [App\Http\Controllers\PaymentController::class, 'handleWebhook']);


Route::get('/privacy', function () {
    return Inertia::render('Frontend/Privacy');
})->name('privacy');

Route::get('/terms', function () {
    return Inertia::render('Frontend/Terms');
})->name('terms');

Route::get('/contact', function () {
    return Inertia::render('Frontend/Contact');
})->name('contact');

Route::get('/cancellation', function () {
    return Inertia::render('Frontend/CancellationRefund');
})->name('cancellation');

Route::get('/debug/fix-drive-quota', function (GoogleClientFactory $factory) {
    try {
        $adminDrive = $factory->createAdminDriveService();

        // Now calling the public method we just added
        $adminDrive->emptyTrash();

        return "Success! Trash has been emptied. You can now try logging in.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
