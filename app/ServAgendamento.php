<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ServAgendamento extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "servagendamento";
    protected $primaryKey = "idServAgendamento";
    protected $fillable = ['idServAgendamento','idAgendamento','idServico'];
    protected $dates = ['deleted_at'];
}
