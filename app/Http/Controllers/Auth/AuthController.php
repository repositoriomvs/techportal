<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActividadUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Registrar ingreso
            $actividad = ActividadUsuario::create([
                'user_id'  => Auth::id(),
                'login_at' => now(),
                'ip'       => $request->ip(),
            ]);

            // Guardar ID de actividad en sesión para el logout
            session(['actividad_id' => $actividad->id]);

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Registrar logout y calcular duración
        $actividadId = session('actividad_id');
        if ($actividadId) {
            $actividad = ActividadUsuario::find($actividadId);
            if ($actividad) {
                $actividad->update([
                    'logout_at'         => now(),
                    'duracion_minutos'  => (int) $actividad->login_at->diffInMinutes(now()),
                ]);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}