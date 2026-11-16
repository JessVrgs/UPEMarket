<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MOdels\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function mostrarLogin(){
        return "Mau, CONECTA AQUÍ LA VISTA AL LOGIN";
    }

    public function procesarLogin(Request $request){
        try{
            $credenciales = $request->validate([
                'email'     => 'required|email',
                'password'  => 'required'
            ]);

            if(Auth::attempt($credenciales)){
                $request->session()->regenerate();

                return response()->json([
                    'estado'    => 'Éxito', 
                    'mensaje'   => 'Bienvenido a UPEMarket, ' .Auth::user()->nombre
                ]);
            }

            //contraseña incorrecta
            return response()->json([
                'estado'    => 'Error de autenticación',
                'mensaje'   => 'Usuario y/o contraseña incorrectos.'
            ], 401);
        } catch(\Exception $e){
            return response()->json([
                'estado'    => 'Error del servidor',
                'mensaje'   => 'Inicio de sesión fallido',
                'detalle'   => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response->json([
            'estado'    => 'Éxito',
            'mensaje'   => 'Sesión cerrada con éxito'
        ]);
    }

    public function mostrarRegistro(){
        return "Conexión a la vista";
    }

    public function procesarRegistro(Request $request){
        try{
            //validaciones
            $request->validate([
                'nombre'    => 'required|string|max:255',
                'email'     => ['required', 'email', 'ends_with:@upemor.edu.mx'],
                'password'  => 'required|min:6',
                'carrera'   => 'required|string|max:100',
                'telefono'  => 'nullable|numeric|digits:10'
            ]);

            //CReación del user
            $usuario = new User();
            $usuario->nombre = $request->nombre;
            $usuario->email = $request->correo;
            $usuario->carrera = $request->carrera;
            $usuario->telefono = $request->telefono;

            //asignación de rol (estudiante)
            $usuario->rol = 'estudiante';
            $usuario->activo = true;
            
            // cifrado de password
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            return response()->json([
                'estado'    => 'Éxito',
                'mensaje'   => 'Usuario registrado correctamente'
            ]);

        } catch(ValidationException $e){
            //valida correo o campos vacios
            return response()->json([
                'estado'    => 'Error de validación',
                'detalles'  => $e->errors()
            ], 422);

        } catch(\Exception $e){
            //eroores del sistema
            return response()->json([
                'estado'    => 'Error del servidor',
                'mensaje'   => 'NO se pudo registrar al usuario',
                'detalles'  => $e->getMessage()
            ], 500);
        }
    }
}
