<?php

namespace App\OrmModel\OrmField;

use Form;
use Carbon\Carbon;
use App\OrmModel\Resource;
use Illuminate\Http\Request;
use App\OrmModel\OrmField\Field;
use Illuminate\Database\Eloquent\Model;

class Date extends Field
{
    public $inputDateFormat = 'Y-m-d';
    public $outputDateFormat = 'Y-m-d';
    /**
     * Devuelve valor del campo formateado
     * @param  Request    $request
     * @param  Model|null $model
     * @return mixed
     */
    public function getValue(Model $model = null, Request $request)
    {

        return optional($model->{$this->attribute})->format($this->outputDateFormat);
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

        return Form::date($this->attribute, $value, $extraParam);
    }

}
