<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('auth.form-login');
    }

    public function processLogin(Request $request)
    {
        $request->validate(User::validationRules('formLogin'), User::validationMessages('formLogin'));

        $credentials = $request->only(['email', 'password']);

        if(!auth()->attempt($credentials)) {
            return redirect()
                ->route('auth.formLogin')
                ->with('status.message', 'Las credenciales ingresadas no coinciden con nuestros registros.')
                ->with('status.type', 'error')
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()
            ->route('movies.index')
            ->with('status.message', 'Iniciaste sesión con éxito. ¡Hola de nuevo!');
    }

    public function formRegister()
    {
        return view('auth.form-register');
    }

    public function processRegister(Request $request)
    {
        $request->validate(User::validationRules('formRegister'), User::validationMessages('formRegister'));

        $data = $request->only(['email', 'password']);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if($user) {
            return redirect()
                ->route('auth.formLogin')
                ->with('status.message', 'Tu cuenta fue creada con éxito.');
        }
    }

    public function processLogout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.formLogin')
            ->with('status.message', 'Cerrarse tu sesión con éxito. ¡Volvé pronto!');
    }
}
