<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function perguntas(): HasMany
    {
        return $this->hasMany(Pergunta::class);
    }
        // TICKET #010: Relacionamento Inverso de Votos
        public function perguntasVotadas()
        {
            return $this->belongsToMany(Pergunta::class, 'pergunta_user')->withTimestamps();
        }
    
}
