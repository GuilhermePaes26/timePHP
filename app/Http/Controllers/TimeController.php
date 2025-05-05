<?php
namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;

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
            'imagem' => 'nullable|string',
        ]);

        return Time::create($validated);
    }

    public function show($id)
    {
        return Time::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $time = Time::findOrFail($id);
        $time->update($request->all());
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
