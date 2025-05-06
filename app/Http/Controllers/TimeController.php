<?php
namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimeController extends Controller
{
    public function index()
    {
        return Time::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string',
            'titulos' => 'required|integer',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Salva a imagem e guarda o caminho, se houver
        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('public/imagens');
            $validated['imagem'] = Storage::url($path); // Gera a URL acessível
        }

        return Time::create($validated);
    }

    public function show($id)
    {
        return Time::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $time = Time::findOrFail($id);

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('public/imagens');
            $request->merge(['imagem' => Storage::url($path)]);
        }

        $time->update($request->only(['nome', 'titulos', 'imagem']));
        return $time;
    }

    public function destroy($id)
    {
        $time = Time::findOrFail($id);
        $time->delete();
        return response()->json(['mensagem' => 'Time removido com sucesso']);
    }

    public function jogadores($id)
    {
        $time = Time::with('jogadores')->findOrFail($id);
        return $time->jogadores;
    }
}
