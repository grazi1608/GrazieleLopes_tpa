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
}
