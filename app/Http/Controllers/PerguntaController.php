<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;

class PerguntaController extends Controller
{
    /**
     * Incrementa +1 ao número de votos da pergunta sem exigir login.
     */
    public function votar(Pergunta $pergunta)
    {
        $pergunta->increment('votos');

        return redirect()->back();
    }
}