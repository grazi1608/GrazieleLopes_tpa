<?php

namespace App\Http\Controllers;

use App\Models\Evento;
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
        $perguntas = $evento->perguntas()
            ->where('is_public', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }

}