<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Configuracoes extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "configuracoes";
    protected $primaryKey = "id";
}
