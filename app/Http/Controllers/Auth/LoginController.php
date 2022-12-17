<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckEmailRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function checkEmail(CheckEmailRequest $request)
    {
        $user = (bool) User::findByEmail($request->email);

        if ($user) {
            return response()->json(['user' => ['The user exists']]);
        }

        return response()->json(['user' => ['The user does not exist']], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['user' => ['The user or password is not correct']], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::findByEmail($request->email)->first();
        $user->tokens()->delete();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function ping()
    {
        return 'pong';
    }
}
