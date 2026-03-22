<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    /**
     * Register a new player account.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name'        => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'            => ['nullable', 'string', 'max:30'],
            'gender'           => ['nullable', 'in:male,female'],
            'national_ranking' => ['nullable', 'boolean'],
            'password'         => ['required', PasswordRule::min(8)],
        ]);

        $user = User::create([
            'name'             => $validated['full_name'],
            'email'            => $validated['email'],
            'phone'            => $validated['phone'] ?? null,
            'gender'           => $validated['gender'] ?? null,
            'national_ranking' => filter_var($validated['national_ranking'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'password'         => Hash::make($validated['password']),
            'role'             => 'player',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'data'    => [
                'csrf_token' => csrf_token(),
                'role'       => $user->role,
            ],
        ]);
    }

    /**
     * Log an existing player in.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'data'    => [
                'csrf_token' => csrf_token(),
                'role'       => Auth::user()->role,
            ],
        ]);
    }

    /**
     * Log the current user out.
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true]);
    }

    /**
     * Return the currently authenticated user's basic info (session check).
     */
    public function session(Request $request): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['success' => false]);
        }

        /** @var User $user */
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'data'    => [
                'csrf_token' => csrf_token(),
                'role'       => $user->role,
                'full_name'  => $user->name,
                'email'      => $user->email,
            ],
        ]);
    }

    /**
     * Send a password reset link to the given email address.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        Password::sendResetLink($request->only('email'));

        // Always return success to avoid leaking whether an email is registered
        return response()->json([
            'success' => true,
            'message' => 'If an account with that email exists, a reset link has been sent.',
        ]);
    }

    /**
     * Reset the user's password using the token from the reset email.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token'    => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully! You can now log in.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired reset link. Please request a new one.',
        ], 422);
    }
}
