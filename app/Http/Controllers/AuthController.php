<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function mostrarLogin(){
        return view('auth.login');
    }

    public function procesarLogin(Request $request){
        try {
            $request->validate([
                'email'     => 'required|email',
                'password'  => 'required'
            ]);

            // Buscamos al usuario
            $usuario = User::where('email', $request->email)->first();

            // 🔍 LÍNEA DE DEPURACIÓN (Míralo en pantalla o con dd)
            if (!$usuario) {
                return back()->withErrors(['email' => 'El correo no existe en la base de datos.']);
            }

            // Verificamos si la contraseña coincide con el Hash de MongoDB
            if (Hash::check($request->password, $usuario->password)) {
                Auth::login($usuario);
                $request->session()->regenerate();
                return redirect()->intended('/publicaciones');
            } else {
                // Si entra aquí, la contraseña ingresada no coincide con el hash guardado
                return back()->withErrors(['email' => 'La contraseña no coincide con el registro .']);
            }

        } catch(\Exception $e){
            return back()->withErrors(['email' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function mostrarRegistro(){
        return view('auth.register');
    }

    public function procesarRegistro(Request $request){
        try{
            $request->validate([
                'nombre'    => 'required|string|max:255',
                'email'     => ['required', 'email', 'ends_with:@upemor.edu.mx'],
                'password'  => 'required|min:6',
                'carrera'   => 'required|string|max:100',
                'telefono'  => 'nullable|numeric|digits:10'
            ]);

            // Validación adicional por si el correo ya está registrado en MongoDB
            $existe = User::where('email', $request->email)->first();
            if ($existe) {
                return back()->withErrors(['email' => 'Este correo ya se ha registrado.'])->withInput();
            }

            $usuario = new User();
            $usuario->nombre = $request->nombre;
            $usuario->email = $request->email;
            $usuario->carrera = $request->carrera;
            $usuario->telefono = $request->telefono;
            $usuario->rol = 'estudiante';
            $usuario->activo = true;
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            Auth::login($usuario);
            $request->session()->regenerate();

            return redirect('/publicaciones');

        } catch(ValidationException $e){
            return back()->withErrors($e->errors())->withInput();
        } catch(\Exception $e){
            return back()->withErrors(['error' => 'Error del servidor al registrar: ' . $e->getMessage()])->withInput();
        }
    }
}
