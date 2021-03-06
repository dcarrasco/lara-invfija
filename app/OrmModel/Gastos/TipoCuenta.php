<?php

namespace App\OrmModel\Gastos;

use App\Gastos\TipoCuenta as ModelTipoCuenta;
use App\OrmModel\Resource;
use Illuminate\Http\Request;
use App\OrmModel\OrmField\Id;
use App\OrmModel\OrmField\Text;
use App\OrmModel\OrmField\Select;
use App\OrmModel\Gastos\TipoMovimiento;

class TipoCuenta extends Resource
{
    public $model = 'App\Gastos\TipoCuenta';
    public $label = 'Tipo de Cuenta';
    public $labelPlural = 'Tipos de Cuenta';
    public $icono = 'sitemap';
    public $title = 'tipo_cuenta';
    public $search = [
        'id', 'tipo_cuenta'
    ];

    public $orderBy = 'tipo_cuenta';

    public function fields(Request $request)
    {
        return [
            Id::make()->sortable(),

            Text::make('Tipo cuenta')
                ->sortable()
                ->rules('max:50', 'required', 'unique'),

            Select::make('Tipo')
                ->options([
                    ModelTipoCuenta::CUENTA_GASTO => 'Gasto',
                    ModelTipoCuenta::CUENTA_INVERSION => 'Inversion',
                ])
                ->sortable()
                ->rules('required')
        ];
    }
}
