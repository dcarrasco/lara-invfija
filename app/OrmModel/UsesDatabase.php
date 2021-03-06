<?php

namespace App\OrmModel;

use Illuminate\Http\Request;
use App\OrmModel\OrmField\HasMany;

trait UsesDatabase
{
    public $orderBy = [];

    protected $sortByKey = 'sort-by';
    protected $sortDirectionKey = 'sort-direction';
    protected $filterKey = 'filtro';

    /**
     * Agrega condiciones de filtro a objecto modelo
     * @param  Request $request
     * @return Resource
     */
    public function resourceFilter(Request $request)
    {
        if (empty($request->input($this->filterKey))) {
            return $this;
        }

        foreach($this->search as $field) {
            $this->modelObject = $this->modelObject
                ->orWhere($field, 'like', '%'.$request->input($this->filterKey).'%');
        };

        return $this;
    }

    /**
     * Devuelve orden del modelo
     * @return array Arreglo con campos de ordenamiento
     */
    public function getOrder()
    {
        if (!is_array($this->orderBy)) {
            $this->orderBy = [(string) $this->orderBy => 'asc'];
        }

        return $this->orderBy;
    }

    /**
     * Agrega limite de despliegue en listado
     * @param  Request $request
     * @return Resource
     */
    public function resourceSetPerPage(Request $request)
    {
        if (is_null($this->modelObject)) {
            $this->modelObject = $this->makeModelObject();
        }

        $this->modelObject
            ->setPerPage($request->PerPage ?: $this->perPage);

        return $this;
    }

    /**
     * Agrega condiciones order-by a objeto del modelo
     * @param  Request $request
     * @return Resource
     */
    public function resourceOrderBy(Request $request)
    {
        $orderBy = $request->has($this->sortByKey)
            ? [$request->input($this->sortByKey) => $request->input($this->sortDirectionKey, 'asc')]
            : $this->getOrder();

        foreach ($orderBy as $field => $order) {
            $this->modelObject = $this->modelObject->orderBy($field, $order);
        }

        return $this;
    }

    public function findOrFail($modelId)
    {
        $this->injectModel($this->modelObject->findOrFail($modelId));

        return $this;
    }

    public function findOrNew($modelId)
    {
        $this->injectModel($this->modelObject->findOrNew($modelId));

        return $this;
    }

    public function update(Request $request)
    {
        // actualiza el objeto
        $this->modelObject->update($request->all());

        // actualiza las tablas relacionadas
        collect($this->fields($request))
            // filtra los campos de TIPO_HAS_MANY
            ->filter(function($elem) {
                return get_class($elem) === HasMany::class;
            })
            // Sincroniza la tabla relacionada
            ->each(function ($field) use ($request) {
                $this->modelObject->{$field->getAttribute()}()
                    ->sync($request->input($field->getAttribute(), []));
            });

        return $this;
    }

}
