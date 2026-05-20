<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Seguridad\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /** @var list<string> */
    protected array $providers = ['google', 'facebook'];

    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate(
            [
                'proveedor' => $provider,
                'proveedor_id' => $socialUser->getId(),
            ],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Usuario',
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(32)),
                'activo' => true,
            ]
        );

        if ($user->wasRecentlyCreated && empty($user->email)) {
            $user->update([
                'email' => "{$provider}_{$socialUser->getId()}@social.local",
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('home', absolute: false));
    }

    protected function validateProvider(string $provider): void
    {
        abort_unless(in_array($provider, $this->providers, true), 404);
    }
}
