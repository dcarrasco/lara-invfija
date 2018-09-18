<?php

namespace App\OrmModel\Toa;

use App\OrmModel\OrmModel;
use App\OrmModel\OrmField\Text;
use App\OrmModel\OrmField\HasMany;

class Empresa extends OrmModel
{
    public $model = 'App\Toa\Empresa';
    public $icono = 'home';
    public $title = 'empresa';
    public $search = [
        'id_empresa', 'empresa',
    ];
    public $modelOrder = 'empresa';

    public function fields()
    {
        return [
            Text::make('id empresa')
                ->sortable()
                ->rules('max:20', 'required', 'unique'),

            Text::make('empresa')
                ->sortable()
                ->rules('max:50', 'required', 'unique'),

            HasMany::make('tipo almacen sap', 'tipoalmacensap', 'App\OrmModel\Stock\TipoAlmacenSap'),

            HasMany::make('ciudad', 'ciudadToa', 'App\OrmModel\Toa\Ciudad'),
        ];
    }

}
