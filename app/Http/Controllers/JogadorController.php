<?php
namespace App\Http\Controllers;

use App\Models\Jogador;
use Illuminate\Http\Request;

class JogadorController extends Controller
{
    public function index()
    {
        return Jogador::with('time')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string',
            'idade' => 'required|integer',
            'imagem' => 'nullable|string',
            'time_id' => 'required|exists:times,id',
        ]);

        return Jogador::create($validated);
    }

    public function show($id)
    {
        return Jogador::with('time')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $jogador = Jogador::findOrFail($id);
        $jogador->update($request->all());
        return $jogador;
    }

    public function destroy($id)
    {
        $jogador = Jogador::findOrFail($id);
        $jogador->delete();
        return response()->json(['mensagem' => 'Jogador removido com sucesso']);
    }
}
