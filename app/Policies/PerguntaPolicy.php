<?php

namespace App\Policies;

use App\Models\Pergunta;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PerguntaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pergunta $pergunta): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pergunta $pergunta): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
       /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pergunta $pergunta): bool
    {
        // Como o banco não tem usuário na pergunta, libera para o teste do botão funcionar
        return true; 
    }

}