<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Venda extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "venda";
    protected $primaryKey = "idVenda";
    protected $fillable = ['idVenda','idCliente','idPromocao','total','tipoPagamento','obs','status'];
    protected $dates = ['deleted_at'];
}
