<?php

namespace App\Gastos;

use Illuminate\Database\Eloquent\Model;

class TipoGasto extends Model
{
    protected $fillable = ['tipo_gasto'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'cta_tipos_gastos';
    }
}
