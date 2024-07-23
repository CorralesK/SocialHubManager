<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }

        $user = auth()->user();

        if ($user->uses_two_factor) {
            session(['2fa:user:id' => $user->id]);
            auth()->logout();

            return redirect('two-factor/verify');
        }


        session()->regenerate();
        return redirect('/')->with('success', 'Login completed successfully.');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'See you soon!');
    }
}
