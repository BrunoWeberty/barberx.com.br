<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Promocao extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "promocao";
    protected $primaryKey = "idPromocao";
    protected $fillable = ['idPromocao','descricao','porcentagem','img','ativo'];
    protected $dates = ['deleted_at'];
}
