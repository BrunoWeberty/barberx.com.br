<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = "audits";
    protected $primaryKey = "id";
}
