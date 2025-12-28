<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserDriveSetupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    protected $setupService;

    public function __construct(UserDriveSetupService $setupService)
    {
        $this->setupService = $setupService;
    }

    public function redirectToGoogle(Request $request)
    {
        $state = bin2hex(random_bytes(16)) . '-' . $request->query('plan', 'essential');

        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email', 'https://www.googleapis.com/auth/drive'])
            ->with(['access_type' => 'offline', 'prompt' => 'consent', 'state' => $state])
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $plan = str_contains($request->input('state'), '-') ? explode('-', $request->input('state'))[1] : 'essential';

        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'password' => bcrypt(str(\Illuminate\Support\Str::random(12))),
                'google_access_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]
        );

        Auth::login($user);

        if (in_array($plan, ['pro', 'enterprise'])) {
            $api = new \Razorpay\Api\Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $prices = ['pro' => 499, 'enterprise' => 999];
            $order = $api->order->create([
                'receipt' => 'rcpt_' . $user->id . '_' . time(),
                'amount' => $prices[$plan] * 100,
                'currency' => 'INR',
            ]);

            // Record the pending payment
            \App\Models\Payment::create([
                'user_id' => $user->id,
                'plan_type' => $plan,
                'razorpay_order_id' => $order['id'],
                'amount' => $prices[$plan],
                'status' => 'pending',
            ]);

            // Redirect to home but carry the order details in the session
            return redirect()->route('home')->with('razorpay_order', [
                'id' => $order['id'],
                'amount' => $order['amount'],
                'plan' => $plan,
                'razorpay_key' => config('services.razorpay.key'),
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]);
        }
        else{
            $folderId = $this->setupService->getOrCreateUserFolder($user, $plan);

            // Notify User

            return redirect()->route('home')
                ->with('drive_url', "https://drive.google.com/drive/folders/{$folderId}");
        }


    }
}
