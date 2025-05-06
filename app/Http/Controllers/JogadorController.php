<?php
namespace App\Http\Controllers;

use App\Models\Jogador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JogadorController extends Controller
{
    public function index()
    {
        return Jogador::with('time')->get();
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'nome' => 'required|string',
            'idade' => 'required|integer',
            'imagem' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',  // Agora aceita arquivo de imagem com tamanho máximo de 2MB
            'time_id' => 'required|exists:times,id',
        ]);

        // Processamento da imagem, se fornecida
        if ($request->hasFile('imagem')) {
            // Armazena a imagem no diretório 'public/imagens' dentro do storage
            $imagemPath = $request->file('imagem')->store('public/imagens');
        } else {
            $imagemPath = null;  // Se não houver imagem, deixamos como null
        }

        // Adiciona o caminho da imagem aos dados validados
        $validated['imagem'] = $imagemPath;

        // Criação do jogador no banco de dados com os dados validados (incluindo o caminho da imagem, se fornecido)
        return Jogador::create($validated);
    }

    public function show($id)
    {
        return Jogador::with('time')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $jogador = Jogador::findOrFail($id);
        
        // Se a imagem for fornecida, atualiza o campo 'imagem'
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('public/imagens');
            $request->merge(['imagem' => $imagemPath]);
        }

        // Atualiza os dados do jogador com os dados fornecidos
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
