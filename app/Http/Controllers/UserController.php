<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('is.administrator');
    }

    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $user = User::findOrFail($user->id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user = User::findOrFail($user->id);
        $user->name = $request->name;
        $user->cuit = $request->cuit;
        $user->razon = $request->razon;
        $user->address = $request->address;

        $user->save();

        return back()->with('mensaje', 'Usuario editado');
    }
}