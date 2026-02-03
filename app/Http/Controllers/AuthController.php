<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Support\Facades\Hash;
use App\Helper\ResponseHelper;
use Exception;

class AuthController extends Controller
{ 
    public function LoginPage()
    {
        return view('auth.login');
    }

    public function RegistrationPage()
    {
        return view('auth.registration');
    }

    public function dashboard()
    {
        return view('auth.dashboard');
    }
    
    //Registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'nullable|in:student,instructor,admin',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'] ?? 'student',
            ]);

            return ResponseHelper::Out("Success", $user, 201);
        } catch (\Exception $e) {
            return ResponseHelper::Out("Fail", 'Registration Failed', 500);
        }
    }

    //Login
    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email",
            "password" => "required|string|min:6"
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return ResponseHelper::Out("Fail", 'Invalid credentials', 401);
        }

        $token = JWTToken::CreateToken($user->email, $user->id, $user->role);

        return  ResponseHelper::Out("Success", 'Login Successful', 200)
            ->cookie('token', $token, 60 * 24, '/', null, false, true, false, 'Lax'); //cookie('token',  $token,  60 * 24, '/', null,  true, true,    false,  'Strict');
    }

 //Refresh token
    public function refreshToken(Request $request)
    {
        $oldToken = $request->cookie('token');

        if (!$oldToken) {
            return ResponseHelper::Out('Fail', 'Token missing', 401);
        }

        $decoded = JWTToken::ReadToken($oldToken);

        if ($decoded === 'unauthorized') {
            return ResponseHelper::Out('Fail', 'Invalid or expired token', 401);
        }

        $newToken = JWTToken::CreateToken($decoded->userEmail,  $decoded->userID,  $decoded->role);


        return ResponseHelper::Out('Success', 'Token Refreshed', 200)
            ->cookie('token', $newToken, 60 * 24,  '/',  null, app()->environment('production'),   true,  false, 'Strict');
    }

    //Logout
    public function logout()
    {
        return ResponseHelper::Out('success', 'Logout Successful', 200)->cookie('token', '', -1);
    }
}
