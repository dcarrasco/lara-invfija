<?php

namespace App\OrmModel\OrmField;

use Form;
use App\OrmModel\OrmField\Field;

class Number extends Field
{
    public function getFormattedValue($value = null)
    {
        if ($this->hasChoices()) {
            return array_get($this->getChoices(), $value, '');
        }

        return $value;
    }


    public function getForm($resource = null, $extraParam = [], $parentId = null)
    {
        $extraParam['id'] = $this->name;
        $value = $resource->{$this->getField()};

        if ($this->hasChoices()) {
            return Form::select(
                $this->name,
                array_get($this->choices, $value, ''),
                $value,
                $extraParam
            );
        }

        if ($this->esId and $this->esIncrementing) {
            return '<p class="form-control-static">'.$value.'</p>'
                .Form::hidden($this->name, null, $extraParam);
        }

        return Form::text($this->name, $value, $extraParam);
    }

}