<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $tipo = $request->tipo;

        // Verifica se há um registro de entrada sem uma saída correspondente
        $registro = Registro::where('user_id', $user->id)
                            ->whereNull('saida')
                            ->first();

        if ($tipo == 'entrada') {
            // Se não houver registro de entrada sem saída, cria um novo
            if (!$registro) {
                $registro = new Registro();
                $registro->user_id = $user->id;
                $registro->entrada = now();
                $registro->save();
            }
        } elseif ($tipo == 'saida') {
            // Atualiza o registro existente com a saída
            if ($registro) {
                $registro->saida = now();
                $registro->save();
            } else {
                // Se não houver um registro de entrada sem saída, talvez lançar uma exceção
                return response()->json(['error' => 'Não há registro de entrada para esse usuário.'], 400);
            }
        }

        return response()->json(['message' => 'Registro atualizado com sucesso.', 'timestamp' => now()]);
    }

    public function index()
    {
        $user = Auth::user();
        $registros = Registro::where('user_id', $user->id)->paginate(10); // Aplica a paginação
        return response()->json($registros);
    }
}

