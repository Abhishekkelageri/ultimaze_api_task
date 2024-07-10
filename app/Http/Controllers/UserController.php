<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function storeUsers(Request $request)
    {
        // dd($request);
        $user = new User;
        $user -> name = $request -> fname . ' ' . $request -> lname;
        $user -> email = $request -> email;
        $user -> password = $request -> password;
        $user -> save();
        return view('home');
    }
}
