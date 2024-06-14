<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,saida',
        ]);

        $user = Auth::user();

        $registro = Registro::create([
            'user_id' => $user->id,
            'entrada' => $request->tipo === 'entrada' ? now() : null,
            'saida' => $request->tipo === 'saida' ? now() : null,
        ]);

        $message = $request->tipo === 'entrada' ? 'Ponto de entrada registrado com sucesso' : 'Ponto de saída registrado com sucesso';
        $timestamp = $request->tipo === 'entrada' ? $registro->entrada : $registro->saida;

        return response()->json([
            'message' => $message,
            'timestamp' => $timestamp,
            'registro' => $registro,
        ], 201);
        }

    public function index()
    {
        $user = Auth::user();
        $registros = $user->registros;
        return response()->json($registros);
    }
}
