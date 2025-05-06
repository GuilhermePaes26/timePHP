<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jogador;
use App\Models\Time;

class CadastroController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome_jogador' => 'required|string|max:255',
            'idade_jogador' => 'required|integer|min:16',
            'imagem_jogador' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nome_time' => 'required|string|max:255',
            'titulo_time' => 'required|string|max:255',
            'imagem_time' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Processar as imagens e salvar
        $imagemJogador = $request->file('imagem_jogador')->store('public/images');
        $imagemTime = $request->file('imagem_time')->store('public/images');

        // Criar jogador
        $jogador = Jogador::create([
            'nome' => $request->nome_jogador,
            'idade' => $request->idade_jogador,
            'imagem' => $imagemJogador,
        ]);

        // Criar time
        $time = Time::create([
            'nome' => $request->nome_time,
            'titulo' => $request->titulo_time,
            'imagem' => $imagemTime,
        ]);

        // Retornar sucesso
        return response()->json(['message' => 'Cadastro realizado com sucesso!'], 200);
    }
}
