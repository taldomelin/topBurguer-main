<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(){
        $clientes = Cliente::all();
        
        $clientesComImagem = $clientes->map(function($cliente){
            return [
                'foto' => asset('storage/' . $cliente->imagem),
                'nome' => $cliente->nome,
                'telefone' => $cliente->telefone,
                'endereco' => $cliente->endereco,
                'email' => $cliente->email,
                'password' => $cliente->password
            ];
        });
        return response()->json($clientesComImagem);
    }

    public function store (Request $request){
        $clienteData = $request->all();

        if($request->hasFile('foto')){
            $foto = $request->file('foto');
            $nomeFoto = time().'.'.$foto->getClientOriginalExtension();
            $caminhoFoto = $foto->storeAs('imagens/clientes', $nomeFoto, 'public');
            $clienteData['foto'] = $caminhoFoto;
        }
        $cliente = Cliente::create($clienteData);
        return response()->json(['cliente' => $cliente], 201);
    }
}