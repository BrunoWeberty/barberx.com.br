<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Produto extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "produto";
    protected $primaryKey = "idProduto";
    protected $fillable = ['idProduto','idMarca','descricao','img','valor','ativo'];
    protected $dates = ['deleted_at'];
}
