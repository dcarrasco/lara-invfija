<?php

namespace App\OrmModel\Inventario;

use App\OrmModel\Resource;
use Illuminate\Http\Request;
use App\OrmModel\OrmField\Text;

class TipoInventario extends Resource
{
    public $model = 'App\Inventario\TipoInventario';
    public $label = 'Tipo de inventario';
    public $labelPlural = 'Tipos de inventario';
    public $icono = 'th';
    public $title = 'desc_tipo_inventario';
    public $search = [
        'desc_tipo_inventario'
    ];
    public $orderBy = ['id_tipo_inventario' => 'asc'];

    public function fields(Request $request)
    {
        return [
            Text::make('id tipo inventario')
                ->sortable()
                ->rules('max:10', 'required', 'unique'),

            Text::make('desc tipo inventario')
                ->sortable()
                ->rules('max:50', 'required', 'unique'),
        ];
    }
}
