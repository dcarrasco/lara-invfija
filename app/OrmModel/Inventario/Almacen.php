<?php

namespace App\OrmModel\Inventario;

use App\OrmModel\Resource;
use Illuminate\Http\Request;
use App\OrmModel\OrmField\Text;

class Almacen extends Resource
{
    public $model = 'App\Inventario\Almacen';
    public $labelPlural = 'Almacenes';
    public $icono = 'home';
    public $title = 'almacen';
    public $search = [
        'centro'
    ];
    public $orderBy = 'almacen';

    public function fields(Request $request)
    {
        return [
            Text::make('almacen')
                ->sortable()
                ->rules('max:10', 'required', 'unique'),
        ];
    }
}
