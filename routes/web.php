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

        // 1. Check current usage BEFORE cleanup
        $about = $adminDrive->service->about->get(['fields' => 'storageQuota']);
        $usageBefore = round($about->storageQuota->usage / 1024 / 1024 / 1024, 2);

        // 2. Empty the Trash
        $adminDrive->service->files->emptyTrash();

        return response()->json([
            'status' => 'success',
            'message' => 'Trash emptied successfully.',
            'usage_before_cleanup' => $usageBefore . ' GB',
            'note' => 'If usage is still high, you may have orphaned files (files with no parent folder) taking up space.'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
