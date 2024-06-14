<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class FuncionarioController extends Controller
{
    //
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $funcionarios = User::where('role', 'employee')->get();
        return response()->json($funcionarios);
    }

    public function store(Request $request) 
    {
        $this->authorize('create', User::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $funcionario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'funcionario',
        ]);

        return response()->json($funcionario, 201);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', User::class);

        $funcionario = User::findOrFail($id);

        $funcionario->update($request->all());

        return response()->json($funcionario);
    }

    public function destroy($id)
    {
        $this->authorize('delete', User::class);

        $funcionario = User::findOrFail($id);
        $funcionario->delete();

        return response()->json(null, 204);
    }

}
