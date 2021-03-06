<?php

namespace App\Gastos;

use Carbon\Carbon;
use App\Gastos\Gasto;
use App\Gastos\TipoGasto;
use App\Gastos\GastosParser;
use Illuminate\Http\Request;
use App\Gastos\GlosaTipoGasto;
use Illuminate\Support\Collection;
use App\Http\Controllers\Gastos\TipoGastoModel;

class VisaParser implements GastosParser
{
    public function procesaMasivo(Request $request)
    {
        if (! $request->has('datos')) {
            return [];
        }

        return collect(explode(PHP_EOL, $request->input('datos')))
            ->filter(function($linea) {
                return $this->esLineaValida($linea);
            })
            ->map(function($linea) use ($request) {
                return $this->procesaLineaMasivo($request, $linea);
            })
            ->filter(function ($gasto) use ($request) {
                $gastoAnterior = (new Gasto)->where([
                    'cuenta_id' => $request->cuenta_id,
                    'anno' => $request->anno,
                    'fecha' => $gasto->fecha,
                    'serie' => $gasto->serie,
                    'monto' => $gasto->monto,
                ])
                ->get()
                ->first();

                return is_null($gastoAnterior);
            });
    }


    protected function procesaLineaMasivo(Request $request, $linea = '')
    {
        if (empty($linea)) {
            return null;
        }

        $linea = collect(explode(' ', $linea));
        $tipoGasto = (new TipoGasto)->findOrNew((new GlosaTipoGasto)->getPorGlosa($request->cuenta_id, $this->getGlosa($linea)));

        return (new Gasto)->fill([
            'cuenta_id' => $request->cuenta_id,
            'anno' => $request->anno,
            'mes' => $request->mes,
            'fecha' => $this->getFecha($linea),
            'serie' => $this->getSerie($linea),
            'glosa' => $this->getGlosa($linea),
            'tipo_gasto_id' => $tipoGasto->id,
            'tipo_movimiento_id' => optional($tipoGasto->tipoMovimiento)->id,
            'monto' => (int) str_replace('.', '', str_replace('$', '', $linea->last())),
            'usuario_id' => auth()->id(),
        ]);
    }

    protected function getIndexFecha(Collection $linea)
    {
        return $linea->filter(function($item) {
                return preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{2}/', $item) === 1;
            })
            ->map(function($item, $key) {
                return $key;
            })
            ->first();
    }

    protected function getFecha(Collection $linea)
    {
        $fecha = $linea->get($this->getIndexFecha($linea));

        return (new Carbon)->create(2000 + (int)substr($fecha, 6, 2), substr($fecha, 3, 2), substr($fecha, 0, 2), 0, 0, 0);
    }

    protected function esLineaValida($linea = '')
    {
        return preg_match('/[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9]/', $linea) === 1;
    }

    protected function getIndexSerie(Collection $linea)
    {
        $indexFecha = $this->getIndexFecha($linea);
        $serie = $linea->get($indexFecha+1).$linea->get($indexFecha+2);

        if (preg_match('/^[0-9]{12}$/', $serie) === 1) {
            return range($indexFecha + 1, $indexFecha + 2);
        }

        return range($indexFecha + 1, $indexFecha + 1);
    }

    protected function getSerie(Collection $linea)
    {
        return $linea->only($this->getIndexSerie($linea))->implode('');
    }

    protected function getGlosa($linea = [])
    {
        $indexFecha = $this->getIndexFecha($linea);
        $indexIni = count($this->getIndexSerie($linea)) === 1 ? $indexFecha + 2 : $indexFecha + 3;
        $indexFin = $this->montosConSigno($linea) ? $linea->count() - 5 : $linea->count() - 8;

        return collect($linea)->only(range($indexIni, $indexFin))->implode(' ');
    }

    protected function montosConSigno(Collection $linea)
    {
        return strpos($linea->last(), '$') !== false;
    }


}
