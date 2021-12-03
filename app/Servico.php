<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Servico extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "servico";
    protected $primaryKey = "idServico";
    protected $fillable = ['idServico','descricao','img','valor','ativo'];
    protected $dates = ['deleted_at'];
}
