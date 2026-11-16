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
        try{
            $request->validate([
                'email'     => 'required|email',
                'password'  => 'required'
            ]);

            // 1. Buscamos al usuario en la base de datos por su correo
            $usuario = User::where('email', $request->email)->first();

            // 2. Verificamos si el usuario existe y si la contraseña coincide
            if ($usuario && Hash::check($request->password, $usuario->password)) {

                // 3. Autenticamos al usuario manualmente
                Auth::login($usuario);
                $request->session()->regenerate();

                return redirect()->intended('/publicaciones');
            }

            // Credenciales incorrectas: regresa al formulario con el error visible
            return back()->withErrors([
                'email' => 'El correo o la contraseña son incorrectos.',
            ])->onlyInput('email');

        } catch(ValidationException $e){
            return back()->withErrors($e->errors())->onlyInput('email');
        } catch(\Exception $e){
            return back()->withErrors([
                'email' => 'Error del servidor al iniciar sesión: ' . $e->getMessage()
            ]);
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
            return back()->withErrors(['error' => 'Error del servidor: ' . $e->getMessage()])->withInput();
        }
    }
}
