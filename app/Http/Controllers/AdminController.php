<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use App\Models\Company;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth()->user();
        $users = User::all()->sortBy('name');
        $userTypes = UserType::all();
        $companies = Company::all();

        return view('admin', ['user' => $user,
                              'users' => $users,
                              'userTypes' => $userTypes,
                              'companies' => $companies]);
    }
}
