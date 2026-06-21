<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\DriverLicense;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['بيانات الدخول غير صحيحة.'],
            ]);
        }

        Auth::guard('web')->login($user);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user->load('roles'),
        ]);
    }

    public function logout(Request $request)
    {
        if ($token = $request->user()->currentAccessToken()) {
            $token->delete();
        } else {
            auth()->guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return response()->json(['message' => 'تم تسجيل الخروج']);
    }

    public function user(Request $request)
    {
        return $request->user()->load('roles', 'driverLicense');
    }

    public function license(Request $request)
    {
        $license = DriverLicense::where('user_id', $request->user()->id)->first();
        $currencySymbols = ['USD' => '$', 'SAR' => '﷼', 'AED' => 'د.إ', 'QAR' => '﷼', 'EUR' => '€'];
        $currencyCode = config('app.currency', 'USD');
        return response()->json([
            'has_approved_license' => $license && $license->status === 'verified',
            'license' => $license,
            'tax' => [
                'enabled' => (bool) config('app.tax_enabled', true),
                'amount' => (float) config('app.tax_amount', 45),
            ],
            'currency' => [
                'code' => $currencyCode,
                'symbol' => $currencySymbols[$currencyCode] ?? '$',
            ],
        ]);
    }
}
