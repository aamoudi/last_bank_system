<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    //
    public function showLogin()
    {
        return response()->view('cms.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string|min:3',
            'remember_me' => 'boolean',
        ]);

        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];

        if (!$validator->fails()) {
            if (Auth::guard('admin')->attempt($credentials, $request->get('remember_me'))) {
                return response()->json(['message' => 'Logged in succesfully'], 200);
                // return redirect()->route('cms.dashboard');
            } else {
                return response()->json(['message' => 'Login failed, please login credentials'], 400);
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    public function editPassword(Request $request)
    {
        return response()->view('cms.auth.edit-password');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'current_password' => 'required|string|password:admin',
            'new_password' => 'required|string|confirmed',
            'new_password_confirmation' => 'required|string',
            // 'new_password_confirmation' => 'required|string|same:new_password',
        ]);

        if (!$validator->fails()) {
            // $user = User::findOrFail($request->user('admin')->id);
            $user = $request->user('admin');
            $user->password = Hash::make($request->get("new_password"));
            $isSaved = $user->save();
            return response()->json(['message' => 'Password changed successfully'], 200);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    public function editProfile(Request $request)
    {
        $cities = City::where('active', true)->get();
        return response()->view('cms.auth.edit-profile', ['cities' => $cities, 'admin' => $request->user('admin')]);
    }

    public function updateProfile(Request $request)
    {
        $admin = $request->user('admin');
        $validator = Validator($request->all(), [
            'city_id' => 'required|numeric|exists:cities,id',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'mobile' => 'required|string|unique:admins,mobile,' .  $admin->id,
            'gender' => 'required|string|in:M,F'
        ]);

        if (!$validator->fails()) {
            $admin = $request->user('admin');
            $admin->first_name = $request->get('first_name');
            $admin->last_name = $request->get('last_name');
            $admin->email = $request->get('email');
            $admin->mobile = $request->get('mobile');
            $admin->city_id = $request->get('city_id');
            $admin->gender = $request->get('gender');
            $isSaved = $admin->save();
            return response()->json(['message' => $isSaved ? 'Admin updated successfully' : 'Failed to create admin!'], $isSaved ? 201 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    public function logout(Request $request)
    {
        auth('admin')->logout();
        // Auth::guard('guardName')->user()
        // $request->user()->logout();
        return redirect()->route('auth.login.view');
    }
}
