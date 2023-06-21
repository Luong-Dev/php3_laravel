<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.account.index', ["users" => $users, 'numberPage' => $numberPage]);
    }

    public function create()
    {
        return view('admin.account.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:50'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:128', 'unique:' . User::class],
            'phone_number' => ['nullable', 'numeric', 'digits_between:10,14'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'integer'],
            'gender' => ['nullable', 'integer'],
            'birth_of_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'min:5', 'max:100']
        ]);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birth_of_date' => $request->birth_of_date,
            'gender' => $request->gender,
            'role' => $request->role,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);
        $users = User::paginate(10);

        return redirect('/admin/accounts');
    }

    public function logout()
    {
        Auth::logout();

        // return redirect()->route('login');
        return redirect('/');
    }
}
