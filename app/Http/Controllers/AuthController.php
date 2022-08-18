<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        if ($user = Auth::user()) 
        {
            if ($user->level == 'admin') {
                return redirect()->intended('dashboard');
            }
            else {
                return redirect()->intended('home');
            }
        }

        return view('auth.login');
    }
        
    /**
     * Method process
     *
     * @param Request $request
     *
     * @return void
     */
    public function process(Request $request)
    {
        $credential = $request->validate([
            'identity' => 'required',
            'password' => 'required'
        ]);

        $credential = $request->only("identity", "password");


        if (Auth::attempt($credential)) {
            $user = Auth::user();
            if ($user->level == 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
            else {
                $request->session()->regenerate();
                return redirect()->intended('home');
            }
        }

        return back()->with("error", "No KTP atau password salah");
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function registration()
    {
        return view('auth.registrasi');
    }

    public function processRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2| max:30',
            'password' => 'required|min:8',
            'identity' => 'numeric|min:16|digits:16'
        ]);
        $input = array(
            "name" => $request->name,
            "password" => bcrypt($request->password),
            "identity" => $request->identity
        );
        User::create($input);
        return redirect()->intended('/')->with('success', 'Pendaftaran Berhasil Silahkan Login.');
    }
}
