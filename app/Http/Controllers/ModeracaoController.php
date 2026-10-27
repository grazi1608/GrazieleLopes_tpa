<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeracaoRequest;
use App\Models\Evento;
use App\Models\Moderacao;
use App\Models\Pergunta;
use Illuminate\Http\Request;

class ModeracaoController extends Controller
{
    /**
     * Registra uma denúncia para a pergunta.
     */
    public function store(StoreModeracaoRequest $request, Pergunta $pergunta)
    {
        $pergunta->moderacoes()->create([
            'motivo' => $request->validated('motivo'),
            'status' => 'analisando',
        ]);

        return redirect()->back()->with('success', 'Denúncia enviada com sucesso.');
    }

    /**
     * Lista a Fila de Moderação do Evento aplicando Eager Loading para evitar o problema N+1.
     */
    public function index(Evento $evento)
    {
        $this->authorize('moderate', $evento);

        $moderacoes = Moderacao::whereHas('pergunta', function ($query) use ($evento) {
            $query->where('evento_id', $evento->id);
        })
        ->with('pergunta')
        ->latest()
        ->paginate(15);

        return view('moderacoes.index', compact('evento', 'moderacoes'));
    }

    /**
     * Atualiza o status da moderação garantindo que apenas o dono/moderador do evento possa agir.
     */
    public function updateStatus(Request $request, Moderacao $moderacao)
    {
        $this->authorize('moderate', $moderacao->pergunta->evento);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:aprovado,rejeitado,analisando'],
        ]);

        $moderacao->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Status atualizado com sucesso.');
    }
    
}