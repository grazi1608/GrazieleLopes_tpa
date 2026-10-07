<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pergunta; // Importa o modelo Pergunta
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::latest()->get();

        return view('eventos.index', compact('eventos'));
    }

    public function show(Evento $evento)
    {
        // Garante o carregamento do relacionamento votos para o Blade verificar o destaque
        $perguntas = $evento->perguntas()
            ->with('votos')
            ->withCount('votos')
            ->orderByDesc('votos_count') // Ordenação Decrescente (Critério 7)
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }



    // SALVAR PERGUNTA: Função que estava faltando e causava o erro 500!
    public function storePergunta(Request $request, Evento $evento)
    {
        $request->validate([
            'conteudo' => 'required|string',
        ]);

        // Salva usando os nomes reais do seu banco de dados
        $evento->perguntas()->create([
            'texto' => $request->conteudo,
        ]);

        return redirect()->back()->with('success', 'Pergunta enviada com sucesso!');
    }


        // TICKET 3: Função para deletar a pergunta protegida
        public function destroyPergunta(Pergunta $pergunta)
        {
            // Guarda o ID do evento antes de deletar a pergunta
            $eventoId = $pergunta->evento_id;
    
            // Deleta do banco de dados
            $pergunta->delete();
    
            // FORÇA O RETORNO: Redireciona direto para a URL do evento em vez de usar o back()
            return redirect()->route('eventos.show', $eventoId)->with('success', 'Pergunta excluída com sucesso!');
        }

            // TICKET #011: Método de Votação com a alternância mágica do toggle()
            public function votar(Pergunta $pergunta)
            {
                // toggle insere se não houver, remove se já houver (Critérios 5 e 6)
                $pergunta->votos()->toggle(auth()->id);

        
                return redirect()->back();
            }

    
}
