<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Usuario extends Authenticatable implements Auditable
{
    use Notifiable;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "usuario";
    protected $primaryKey = "id";
    protected $fillable = [
        'nome', 'login', 'email', 'senha', 'status', 'tipo', 'telefone', 'endereco', 'cpf', 'sexo'
    ];

    protected $hidden = [
        'senha'
    ];

    protected $dates = ['deleted_at'];
}
