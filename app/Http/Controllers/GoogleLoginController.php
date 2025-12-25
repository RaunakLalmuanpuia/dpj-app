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

        $folderId = $this->setupService->getOrCreateUserFolder($user, $plan);

        return redirect()->route('home')
            ->with('drive_url', "https://drive.google.com/drive/folders/{$folderId}");
    }
}
