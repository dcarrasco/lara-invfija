<?php

namespace App\OrmModel;

use DB;
use App\OrmModel\OrmField;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\OrmModel\OrmField\HasMany;
use App\OrmModel\OrmField\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Resource
{
    use UsesFilters;
    use UsesDatabase;
    use UsesCards;

    public $model = '';
    public $label = '';
    public $labelPlural = '';
    public $icono = 'table';
    public $title = 'id';

    public $search = ['id'];

    protected $modelObject = null;
    protected $modelList = null;
    protected $fields = null;

    protected $perPage = 25;

    public function __construct()
    {
        if ($this->model === '') {
            throw new \Exception('Modelo no definido en recurso OrmModel!');
        }

        $this->makeModelObject(request());
    }

    /**
     * Campos del recurso
     * @param  Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [];
    }

    /**
     * Cards del recurso
     * @param  Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Recupera nombre del recurso
     * @return string
     */
    public function getName()
    {
        $fullName = explode("\\", get_class($this));
        return array_pop($fullName);
    }

    /**
     * Devuelve descripcion del recurso
     * @return string
     */
    public function getLabel()
    {
        return empty($this->label) ? class_basename($this) : $this->label;
    }

    /**
     * Devuelve descripcion del recurso en plural
     * @return string
     */
    public function getLabelPlural()
    {
        return empty($this->labelPlural) ? Str::plural($this->getLabel()) : $this->labelPlural;
    }

    /**
     * Devuelve la representación del recurso
     * @param  Request $request
     * @return mixed
     */
    public function title(Request $request)
    {
        return $this->getFieldValue($request, $this->title);
    }

    /**
     * Recupera instancia del modelo del recurso
     * @return Model
     */
    public function model()
    {
        return $this->modelObject;
    }

    /**
     * Genera objecto del modelo del recurso
     * @return Resource
     */
    public function makeModelObject(Request $request)
    {
        if (is_null($this->modelObject)) {
            $this->modelObject = (new $this->model)
                ->setPerPage(empty($request->PerPage) ? $this->perPage : $request->PerPage);
        }

        return $this;
    }

    /**
     * Agrega una instancia del modelo al recurso
     * @param  Model|null $model
     * @return Resource
     */
    public function injectModel(Model $model = null)
    {
        $this->modelObject = is_null($model) ? new $this->model : $model;

        return $this;
    }

    /**
     * Agrega un listado de instancias de modelos al recurso
     * @param  Collection|null $modelList
     * @return Resource
     */
    public function injectModelList(Collection $modelList = null)
    {
        $this->modelList = $modelList;

        return $this;
    }

    /**
     * Recupera el valor de un campo
     * @param  Request $request
     * @param  string  $fieldName   Campo a recuperar
     * @return mixed
     */
    public function getFieldValue(Request $request, $fieldName = '')
    {
        $field = collect($this->fields($request))
            ->first(function($field) use ($fieldName) {
                return $field->getFieldName() === $fieldName;
            });

        return optional($field)->getValue($this->modelObject);
    }

    /**
     * Devuelve campos a mostrar en listado
     * @param  Request $request
     * @return array
     */
    public function indexFields(Request $request)
    {
        return collect($this->fields($request))
            ->filter(function($field) {
                return $field->showOnIndex();
            })
            ->map(function($field) use ($request) {
                return $field->makeSortingIcon($request, $this);
            })
            ->all();
    }

    /**
     * Devuelve campos a mostrar en detalle
     * @param  Request $request
     * @return array
     */
    public function detailFields(Request $request)
    {
        return collect($this->fields($request))
            ->filter(function($field) {
                return $field->showOnDetail();
            })
            ->all();
    }

    /**
     * Devuelve campos a mostrar en formularios
     * @param  Request $request
     * @return array
     */
    public function formFields(Request $request)
    {
        return collect($this->fields($request))
            ->filter(function($field) {
                return $field->showOnForm();
            })
            ->all();
    }

    /**
     * Devuelve arreglo de validacion del recurso
     * @param  Request $request
     * @return array
     */
    public function getValidation(Request $request)
    {
        return collect($this->fields($request))
            ->mapWithKeys(function($field) {
                return [$field->getFieldName($this) => $field->getValidation($this)];
            })
            ->all();
    }

    public function getBelongsToRelations(Request $request)
    {
        $belongsToRelations = collect($this->fields($request))
            ->filter(function($field) {
                return get_class($field) === BelongsTo::class;
            })->map(function($field) {
                return $field->getFieldName();
            })->toArray();

        if (count($belongsToRelations)>0) {
            $this->modelObject = $this->modelObject->with($belongsToRelations);
        }

        return $this;
    }

    /**
     * Devuelve paginador del modelo
     * @return Paginator
     */
    public function getPaginated(Request $request)
    {
        $paginate = $this->modelObject->paginate();

        $this->modelObject = null;
        $this->makeModelObject($request);

        return $paginate;
    }

    /**
     * Devuelve listado de modelos
     * @return Collection
     */
    public function getModelList()
    {
        return $this->modelList;
    }

    /**
     * Genera listado de modelos ordenados y filtrados
     * @param  Request $request
     * @return Collection
     */
    public function modelList(Request $request)
    {
        $this->modelList = $this->makeModelObject($request)
            ->resourceOrderBy($request)
            ->resourceFilter($request)
            ->applyFilters($request)
            ->getBelongsToRelations($request)
            ->getPaginated($request);

        return $this->modelList;
    }

    /**
     * Genera links de paginacion de un listado de modelos
     * @param  Request $request
     * @return HtmlString
     */
    public function getPaginationLinks(Request $request)
    {
        return view('common.app_nova_paginator_detail', [
            'modelList' => $this->modelList,
            'resource' => $this,
            'paginationLinks' => $this->modelList
                ->appends($request->all())
                ->links(),
            ]
        )->render();
    }

    public function getModelAjaxFormOptions(Request $request)
    {
        return ajax_options($this->getModelFormOptions($request));
    }

    public function getModelFormOptions(Request $request)
    {
        $this->makeModelObject()->resourceOrderBy();

        $whereIn = collect($request->all())->filter(function ($elem, $key) {
            return !is_integer($key) and is_array($elem);
        });

        $whereValue = collect($request->all())->filter(function ($elem, $key) {
            return is_integer($key) or !is_array($elem);
        })->all();

        $query = $this->modelObject->where($whereValue);
        if (! $whereIn->isEmpty()) {
            $whereIn->each(function ($elem, $key) use (&$query) {
                return $query->whereIn($key, $elem);
            });
        }

        return $query->get()->mapWithKeys(function ($model) use ($request) {
            return [$model->getKey() => $this->injectModel($model)->title($request)];
        });
    }
}
