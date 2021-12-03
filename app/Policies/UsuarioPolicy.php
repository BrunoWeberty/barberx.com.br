<?php

namespace App\Policies;

use App\User;
use App\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsuarioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the usuario.
     *
     * @param  \App\User  $user
     * @param  \App\Usuario  $usuario
     * @return mixed
     */
    public function view(Usuario $user)
    {
        return $user->tipo === "g";
    }

    /**
     * Determine whether the user can create usuario.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(Usuario $user)
    {
        return $user->tipo === "g";
    }

    /**
     * Determine whether the user can update the usuario.
     *
     * @param  \App\User  $user
     * @param  \App\Usuario  $usuario
     * @return mixed
     */
    public function update(Usuario $user)
    {
        return $user->tipo === "g";
    }

    /**
     * Determine whether the user can delete the usuario.
     *
     * @param  \App\User  $user
     * @param  \App\Usuario  $usuario
     * @return mixed
     */
    public function delete(Usuario $user)
    {
        return $user->tipo === "g";
    }
}
