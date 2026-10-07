@extends('layouts.app')

@section('title', 'Detalhes do Evento')

@section('content')
<div class="container mx-auto px-4 py-6 text-gray-200">
    <!-- Informações do Evento -->
    <div class="max-w-4xl mx-auto bg-gray-800 p-6 rounded-lg shadow-md mb-6 border border-gray-700">
        <h2 class="text-3xl font-bold text-white mb-2">{{ $evento->titulo }}</h2>
        <p class="text-gray-300 leading-relaxed">{{ $evento->descricao }}</p>
    </div>

    <!-- FORMULÁRIO PARA DIGITAR A PERGUNTA -->
    <div class="max-w-4xl mx-auto bg-gray-800 p-6 rounded-lg shadow-md mb-6 border border-gray-700">
        <h3 class="text-xl font-bold text-white mb-4">Faça uma Pergunta</h3>
        
        <form action="{{ route('eventos.perguntas.store', $evento) }}" method="POST">
            @csrf
            <div class="mb-4">
                <textarea 
                    name="conteudo" 
                    rows="3" 
                    class="w-full p-3 bg-gray-900 border border-gray-700 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Digite sua pergunta aqui..."
                    required
                ></textarea>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded-md transition duration-150">
                Enviar Pergunta
            </button>
        </form>
    </div>

    <!-- Seção de Listagem de Perguntas -->
    <div class="max-w-4xl mx-auto bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
        <h3 class="text-xl font-bold text-black mb-4 border-b border-gray-700 pb-2">Perguntas da Galera</h3>

        @if($perguntas->isEmpty())
        <p class="text-gray-400 text-center py-4">Nenhuma pergunta enviada ainda.</p>
    @else
        <div class="space-y-4">
            @foreach($perguntas as $pergunta)
                <div class="flex items-center justify-between p-4 bg-gray-900 rounded-md border border-gray-700">
                    
                    <!-- Bloco do Voto + Texto -->
                    <div class="flex items-center space-x-4 flex-1 pr-4">
                        
                        {{-- TICKET #012: Formulário e Botão de Votação (Upvote) --}}
                                                    {{-- Botão de Votação (Upvote) --}}
                                                    <form action="{{ route('perguntas.votar', $pergunta) }}" method="POST">
                                                        @csrf
                                                        @php
                                                            // Destaca apenas se o usuário real estiver logado E já tiver votado
                                                            $jaVotou = auth()->check() && $pergunta->votos->contains(auth()->id());
                                                        @endphp
                                                        
                                                        <button type="submit" 
                                                            class="flex flex-col items-center px-3 py-1 rounded transition duration-150 {{ $jaVotou ? 'bg-blue-600 text-white font-bold ring-2 ring-blue-400' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                                                            <span class="text-lg leading-none">▲</span>
                                                            <span class="text-xs font-bold mt-1">{{ $pergunta->votos_count ?? 0 }}</span>
                                                        </button>
                                                    </form>
                        


                        <!-- Texto da Pergunta -->
                        <div>
                            <p class="text-gray-200 font-medium">
                                {{ $pergunta->texto }}
                            </p>
                        </div>
                    </div>

                    <!-- Formulário de Exclusão -->
                    <form action="{{ route('perguntas.destroy', $pergunta) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>
                            Excluir
                        </x-danger-button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Paginação -->
        <div class="mt-4">
            {{ $perguntas->links() }}
        </div>
    @endif

    </div>
</div>
@endsection

