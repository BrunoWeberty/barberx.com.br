<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ItemVenda extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "itemvenda";
    protected $primaryKey = "idItemVenda";
    protected $fillable = ['idItemVenda','idVenda','idProduto','quantidade','valor'];
    protected $dates = ['deleted_at'];
}
