<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    protected $fillable = ['texto', 'evento_id', 'status'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    // TICKET #010: Relacionamento de Votos (Muitos para Muitos)
    public function votos()
    {
        return $this->belongsToMany(User::class, 'pergunta_user')->withTimestamps();
    }
}
