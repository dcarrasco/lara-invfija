<?php

namespace App\OrmModel\OrmField;

use Form;
use App\OrmModel\Resource;
use Illuminate\Http\Request;
use App\OrmModel\OrmField\Field;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;

class Boolean extends Field
{
    /**
     * Devuelve valor del campo formateado
     * @param  Request    $request
     * @param  Model|null $model
     * @return mixed
     */
    public function getValue(Model $model = null, Request $request)
    {
        return new HtmlString("<small><span class=\"fa fa-circle text-"
            . ($model->{$this->attribute} ? "success" : "danger")
            . "\"></span></small>");

        // return $model->{$this->attribute}
            // ? "<small><span class=\"fa fa-circle text-success\"></span></small>&nbsp;&nbsp;" . trans('orm.radio_yes')
            // : "<small><span class=\"fa fa-circle text-danger\"></span></small>&nbsp;&nbsp;" . trans('orm.radio_no');
    }

    /**
     * Devuelve elemento de formulario para el campo
     * @param  Request  $request
     * @param  Resource $resource
     * @param  array    $extraParam
     * @return HtmlString
     */
    public function getForm(Request $request, Resource $resource, array $extraParam = [])
    {
        $extraParam['id'] = $this->attribute;
        $value = $resource->model()->{$this->attribute};

        return new HtmlString('<div class="custom-control custom-radio">'
            .Form::radio($this->name, 1, ($value == '1'), ['id' => 'id_'.$this->name.'_1', 'class' => 'custom-control-input'])
            .'<label class="custom-control-label" for="id_'.$this->name.'_1">'.trans('orm.radio_yes').'</label>'
            .'</div>'
            .'<div class="custom-control custom-radio">'
            .Form::radio($this->name, 0, ($value != '1'), ['id' => 'id_'.$this->name.'_0', 'class' => 'custom-control-input'])
            .'<label class="custom-control-label" for="id_'.$this->name.'_0">'.trans('orm.radio_no').'</label>'
            .'</div>');
    }
}
