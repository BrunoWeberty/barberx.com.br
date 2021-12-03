<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Agendamento extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "agendamento";
    protected $primaryKey = "idAgendamento";
    protected $fillable = ['idAgendamento','idCliente','idFunc','idServico','dataHora','descricao','total','status'];
    protected $dates = ['deleted_at'];
}
