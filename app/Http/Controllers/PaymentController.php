<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\UserDriveSetupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    //
    public function verifyPayment(Request $request, UserDriveSetupService $setupService)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);

            // 1. Update Payment Record
            $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();
            $payment->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'completed',
            ]);

            // 2. Trigger Drive Service
            $folderId = $setupService->getOrCreateUserFolder($request->user(), $request->plan);

            $payment->update([
                'folder_id_created' => $folderId,
            ]);

            //Notify User...

            return redirect()->route('home')
                ->with('drive_url', "https://drive.google.com/drive/folders/{$folderId}")->with('is_paid', true);

        } catch (\Exception $e) {
            // Update status to failed
            Payment::where('razorpay_order_id', $request->razorpay_order_id)
                ->update(['status' => 'failed']);

            return redirect()->route('home')->with('error', 'Payment verification failed.');
        }
    }

    public function handleWebhook(Request $request, UserDriveSetupService $setupService)
    {

        $payload = $request->getContent();

        $data = json_decode($payload, true);

        // 1. Handle payment.captured event
        if ($data['event'] === 'payment.captured') {
            $orderId = $data['payload']['payment']['entity']['order_id'];
            $paymentId = $data['payload']['payment']['entity']['id'];

            $payment = Payment::where('razorpay_order_id', $orderId)->first();

            if ($payment && $payment->status !== 'completed') {
                // Update payment record
                $payment->update([
                    'razorpay_payment_id' => $paymentId,
                    'status' => 'completed',
                ]);

                // Trigger Drive Setup
                $user = $payment->user;
                $setupService->getOrCreateUserFolder($user, $payment->plan_type);

                //Notify User...
                Log::info("Webhook processed Drive setup for User: {$user->email}");

            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
