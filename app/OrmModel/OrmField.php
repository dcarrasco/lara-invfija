<?php

namespace App\OrmModel;

use Form;

class OrmField
{
    const TIPO_ID = 'ID';
    const TIPO_INT = 'INT';
    const TIPO_REAL = 'REAL';
    const TIPO_CHAR = 'CHAR';
    const TIPO_BOOLEAN = 'BOOLEAN';
    const TIPO_DATETIME = 'DATETIME';
    const TIPO_HAS_ONE = 'HAS_ONE';
    const TIPO_HAS_MANY = 'HAS_MANY';

    protected $name = '';
    protected $label = '';
    protected $tipo = '';
    protected $largo;
    protected $textoAyuda = '';
    protected $choices = [];
    protected $onChange = '';
    protected $mostrarLista = true;
    protected $parentModel = null;
    protected $relationModel = null;
    protected $relationConditions = [];
    protected $esObligatorio = false;
    protected $esUnico = false;
    protected $esId = false;
    protected $esIncrementing = false;

    public function __construct(array $atributos = [])
    {
        $atributosValidos = [
            'name',
            'label',
            'tipo',
            'largo',
            'textoAyuda',
            'mostrarLista',
            'choices',
            'onChange',
            'parentModel',
            'parentId',
            'relationModel',
            'relationConditions',
            'esObligatorio',
            'esUnico',
            'esId',
            'esIncrementing',
        ];

        foreach ($atributos as $atributo => $valor) {
            if (in_array($atributo, $atributosValidos)) {
                $this->{$atributo} = $valor;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     *
     * @return self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * @param mixed $largo
     *
     * @return self
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextoAyuda()
    {
        return $this->textoAyuda;
    }

    /**
     * @param mixed $textoAyuda
     *
     * @return self
     */
    public function setTextoAyuda($textoAyuda)
    {
        $this->textoAyuda = $textoAyuda;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMostrarLista()
    {
        return $this->mostrarLista;
    }

    /**
     * @param mixed $mostrarLista
     *
     * @return self
     */
    public function setMostrarLista($mostrarLista)
    {
        $this->mostrarLista = $mostrarLista;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param mixed $choices
     *
     * @return self
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasChoices()
    {
        return count($this->choices) > 0;
    }

    /**
     * @return mixed
     */
    public function getOnChange()
    {
        return $this->onChange;
    }

    /**
     * @param mixed $onChange
     *
     * @return self
     */
    public function setOnChange($onChange)
    {
        $this->onChange = $onChange;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasOnChange()
    {
        return !empty($this->onChange);
    }

    /**
     * @return mixed
     */
    public function getRelationModel()
    {
        return $this->relationModel;
    }

    /**
     * @param mixed $relationModel
     *
     * @return self
     */
    public function setRelationModel($relationModel)
    {
        $this->relationModel = $relationModel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelationConditions()
    {
        return $this->relationConditions;
    }

    /**
     * @param mixed $relationConditions
     *
     * @return self
     */
    public function setRelationConditions($relationConditions)
    {
        $this->relationConditions = $relationConditions;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasRelationConditions()
    {
        return count($this->relationConditions) > 0;
    }

    /**
     * @return mixed
     */
    public function getEsObligatorio()
    {
        return $this->esObligatorio;
    }

    /**
     * @param mixed $esObligatorio
     *
     * @return self
     */
    public function setEsObligatorio($esObligatorio)
    {
        $this->esObligatorio = $esObligatorio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEsUnico()
    {
        return $this->esUnico;
    }

    /**
     * @param mixed $esUnico
     *
     * @return self
     */
    public function setEsUnico($esUnico)
    {
        $this->esUnico = $esUnico;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAtributosValidos()
    {
        return $this->atributosValidos;
    }

    /**
     * @param mixed $atributosValidos
     *
     * @return self
     */
    public function setAtributosValidos($atributosValidos)
    {
        $this->atributosValidos = $atributosValidos;

        return $this;
    }

    public function getValidation()
    {
        $validation = [];

        if ($this->esObligatorio) {
            $validation[] = 'required';
        }

        if ($this->tipo === OrmField::TIPO_CHAR and $this->largo) {
            $validation[] = 'max:'.$this->largo;
        }

        if ($this->tipo === OrmField::TIPO_INT) {
            $validation[] = 'integer';
        }

        return collect($validation)->implode('|');
    }

    public function getRelatedModel($class = '')
    {
        $relatedModelClass = $class === '' ? $this->relationModel : $class;

        if (!empty($relatedModelClass)) {
            return new $relatedModelClass;
        }

        return;
    }

    public function getFormattedValue($value = null)
    {
        if ($this->tipo === OrmField::TIPO_BOOLEAN) {
            return $value ? trans('orm.radio_yes'): trans('orm.radio_no');
        }

        if ($this->tipo === OrmField::TIPO_HAS_ONE) {
            return (string) $this->getRelatedModel()->find($value);
        }

        if ($this->hasChoices()) {
            return array_get($this->getChoices(), $value, '');
        }

        if ($this->tipo === OrmField::TIPO_HAS_MANY) {
            return $value ? $value->reduce(function ($list, $relatedObject) {
                return $list.'<li>'.(string) $relatedObject.'</li>';
            }, '<ul>').'</ul>' : null;
        }

        return $value;
    }

    public function getForm($value = null, $parentId = null, $extraParam = [])
    {
        $extraParam['id'] = $this->name;

        if ($this->tipo === OrmField::TIPO_CHAR and $this->largo) {
            $extraParam['maxlength'] = $this->largo;
        }

        if ($this->esId and $this->esIncrementing) {
            return '<p class="form-control-static">'.$value.'</p>'
                .Form::hidden($this->name, null, $extraParam);
        }

        if ($this->tipo === OrmField::TIPO_BOOLEAN) {
            return '<label class="radio-inline" for="">'
                .Form::radio($this->name, 1, ($value == '1'), ['id' => ''])
                .trans('orm.radio_yes')
                .'</label>'
                .'<label class="radio-inline" for="">'
                .Form::radio($this->name, 0, ($value != '1'), ['id' => ''])
                .trans('orm.radio_no')
                .'</label>';
        }

        if ($this->hasChoices()) {
            return Form::select(
                $this->name,
                array_get($this->choices, $value, ''),
                $value,
                $extraParam
            );
        }

        if ($this->tipo === OrmField::TIPO_HAS_ONE) {
            if ($this->hasOnChange()) {
                $route = \Route::currentRouteName();
                list($routeName, $routeAction) = explode('.', $route);

                $elemDest = $this->onChange;
                $url = route($routeName.'.ajaxOnChange', ['modelName' => $elemDest]);
                $extraParam['onchange'] = "$('#{$elemDest}').html('');"
                    ."$.get('{$url}?{$this->name}='+$('#{$this->name}').val(), "
                    ."function (data) { $('#{$elemDest}').html(data); });";
            }

            return Form::select(
                $this->name,
                $this->getRelatedModel()->getModelFormOptions(),
                $value,
                $extraParam
            );
        }

        if ($this->tipo === OrmField::TIPO_HAS_MANY) {
            $elementosSelected = collect($value)
                ->map(function ($modelElem) {
                    return $modelElem->{$modelElem->getKeyName()};
                })->all();

            $relatedModelFilter = $this->getRelatedModel($this->parentModel)
                ->find($parentId)
                ->getWhereFromRelation($this->name);

            return Form::select(
                $this->name.'[]',
                $this->getRelatedModel()->getModelFormOptions($relatedModelFilter),
                $elementosSelected,
                array_merge(['multiple' => 'multiple', 'size' => 7], $extraParam)
            );
        }

        return Form::text($this->name, $value, $extraParam);
    }
}