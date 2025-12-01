<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthClienteController extends Controller
{
   
    public function register(Request $request)
    {
        $request->validate([
            'nombre'   => 'required',
            'email'    => 'required|email|unique:clientes,email',
            'password' => 'required|min:4',
        ]);

        $cliente = Cliente::create([
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Cliente registrado',
            'cliente' => $cliente,
        ], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $cliente = Cliente::where('email', $request->email)->first();

        if (! $cliente || ! Hash::check($request->password, $cliente->password)) {
            return response()->json(['message' => 'Datos incorrectos'], 401);
        }

        if (! $cliente->esta_verificado) {
            return response()->json(['message' => 'Cuenta no verificada'], 403);
        }

        return response()->json([
            'message' => 'Login correcto',
            'cliente' => $cliente,
        ]);
    }

   
    public function enviarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $cliente = Cliente::where('email', $request->email)->first();

        if (! $cliente) {
            return response()->json(['message' => 'Cliente no existe'], 404);
        }


        $codigo = rand(1000, 9999);

        $cliente->codigo_verificacion = $codigo;
        $cliente->save();

      
        return response()->json([
            'message'     => 'Código generado',
            'codigo_demo' => $codigo,
        ]);
    }


    public function validarCodigo(Request $request)
    {
        $request->validate([
            'email'  => 'required|email',
            'codigo' => 'required',
        ]);

        $cliente = Cliente::where('email', $request->email)
            ->where('codigo_verificacion', $request->codigo)
            ->first();

        if (! $cliente) {
            return response()->json(['message' => 'Código inválido'], 400);
        }

        $cliente->esta_verificado = true;
        $cliente->codigo_verificacion = null;
        $cliente->save();

        return response()->json([
            'message' => 'Cuenta verificada',
            'cliente' => $cliente,
        ]);
    }
}
