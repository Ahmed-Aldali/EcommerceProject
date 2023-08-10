<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return response()->view('dashboard.login.login');
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:4'
        ],[
            'email.required' => 'الايميل مطلوب'
        ]);

        $credintials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if(! $validator->fails()){
            // if(Auth::guard($request->get('guard'))->attempt($credintials)){
            if(Auth::guard('admin')->attempt($credintials)){
                return response()->json([
                    'icon' => 'success',
                    'title' => 'login is successfully'
                ],200);
            }else{
                return response()->json([
                    'icon' => 'error',
                    'title' => 'login is failed'
                ],400);
            }

        }else{
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first()
            ],400);
        }
    }
}