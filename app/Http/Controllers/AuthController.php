<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
// use Socialite;
use Auth;
use Exception;

class AuthController extends Controller
{
    /**
     * 
     */
    public function redirect()
    {
        // return Socialite::driver('google')->redirect();
    }

    /**
     * 
     */
    public function callback()
    {
        // try
        // {
            // $googleUser = Socialite::driver('google')->user();
         

            // if(! strripos($googleUser->email, '@cnec.br'))
            // {
            //     abort(422, "O dominio do e-mail deverá conter CNEC.BR ");
            // }

            // $exist = User::where('email', $googleUser->email)->first();

            // if($exist)
            // {
            //     Auth::loginUsingId($exist->id);
            // }
            // else
            // {
            //     $user = User::create([
            //         'name'        => $googleUser->name,
            //         'email'       => $googleUser->email,
            //         'password'    =>  Hash::make(rand(1,10000)),
            //         'provider'    => 'google',
            //         'provider_id' => $googleUser->id,
            //     ]);
            //     Auth::loginUsingId($user->id);
            // }
            // return redirect()->to('/home');

        // } 
        // catch (Exception $e)
        // {
        //     dd($e);
        //     abort(422, "Ocorreu um erro");
        // }
    }
}