<?php

namespace App\OrmModel\OrmField;

use Form;
use App\OrmModel\Resource;
use Illuminate\Http\Request;
use App\OrmModel\OrmField\Field;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;

class Currency extends Field
{
    /**
     * Devuelve valor del campo formateado
     * @param  Request    $request
     * @param  Model|null $model
     * @return mixed
     */
    public function getValue(Model $model = null, Request $request)
    {
        return new HtmlString('$&nbsp;'
            .number_format(optional($model)->{$this->attribute}, 0, ',', '.')
        );
    }

    /**
     * Devuelve elemento de formulario para el campo
     * @param  Request  $request
     * @param  Resource $resource
     * @param  array    $extraParam
     * @return HtmlString
     */
    public function getForm(Request $request, Resource $resource, $extraParam = [])
    {
        $extraParam['id'] = $this->attribute;
        $value = $resource->model()->{$this->attribute};

        return Form::number($this->attribute, $value, $extraParam);
    }

}
