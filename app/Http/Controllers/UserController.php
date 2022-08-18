<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        if ($request->ajax()) {
            $data = User::where('id', Auth::user()->id);    
            return DataTables()->of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('user.home');
    }

    
}
