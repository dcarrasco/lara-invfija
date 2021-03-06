<?php

namespace App\OrmModel;

use App\OrmModel\Metric;
use Illuminate\Http\Request;

class Value extends Metric
{
    protected $dateFormat = 'Y-m-d';
    protected $prefix = '';
    protected $suffix = '';


    public function sum(Request $request, $model = '', $sumColumn = '', $timeColumn = 'created_at')
    {
        $currentDateInterval = $this->dateInterval($request);
        $previousDateInterval = $this->dateInterval($request, 'previous');

        return $this->formattedData([
            'currentValue' => $this->fetchSumData($request, $model, $sumColumn, $timeColumn, $currentDateInterval),
            'previousValue' => $this->fetchSumData($request, $model, $sumColumn, $timeColumn, $previousDateInterval),
        ]);
    }

    public function count(Request $request, $model = '', $timeColumn = 'created_at')
    {
        $currentDateInterval = $this->dateInterval($request);
        $previousDateInterval = $this->dateInterval($request, 'previous');

        return $this->formattedData([
            'currentValue' => $this->fetchCountData($request, $model, $timeColumn, $currentDateInterval),
            'previousValue' => $this->fetchCountData($request, $model, $timeColumn, $previousDateInterval),
        ]);
    }

    protected function fetchSumData(Request $request, $model = '', $sumColumn = '', $timeColumn = '', $dateInterval = [])
    {
        return $this->getModelData($request, $model, $timeColumn, $dateInterval)
            ->sum($sumColumn);
    }

    protected function fetchCountData(Request $request, $model = '', $timeColumn = '', $dateInterval = [])
    {
        return $this->getModelData($request, $model, $timeColumn, $dateInterval)
            ->count();
    }

    protected function previousMessage($currentValue, $previousValue)
    {
        if (empty($previousValue)) {
            return "Sin datos anteriores";
        }

        $percentChange = ($currentValue / $previousValue - 1) * 100;
        $textChange = $percentChange >= 0 ? 'aumento' : 'disminucion';

        return number_format($percentChange, 0, '.', ',') . '% de ' . $textChange;
    }

    protected function formattedData($data = [])
    {
        return [
            'currentValue' => $this->prefix.' '.number_format(array_get($data, 'currentValue', 0), 0, ',', '.').' '.$this->suffix,
            'previousValue' => $this->previousMessage(array_get($data, 'currentValue', 0), array_get($data, 'previousValue', 0)),
        ];
    }

    public function prefix($prefix = '')
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function suffix($suffix = '')
    {
        $this->suffix = $suffix;

        return $this;
    }

    protected function content(Request $request)
    {
        $data = $this->calculate($request);

        $currentValue = array_get($data, 'currentValue', 0);
        $previousValue = array_get($data, 'previousValue', 0);

        $content = <<<EOD
            <div class="col-md-12">
                <h1 class="">$currentValue</h1>
            </div>
            <div class="col-md-12">
                <h5 class="text-secondary">$previousValue</h2>
            </div>
EOD;

        return $content;
    }

    protected function contentScript(Request $request)
    {
        $urlRoute = route('gastosConfig.ajaxCard', [request()->segment(2)]);
        $cardId = $this->cardId();
        $resourceParams = json_encode($request->query());

        return <<<EOD
<script type="text/javascript">
    function loadCardData_{$cardId}(uriKey, cardId) {
        $('#spinner-' + cardId).removeClass('d-none');
        $.ajax({
            url: '$urlRoute',
            data: {
                ...{'range': $('#select-' + cardId + ' option:selected').val(), 'uri-key': uriKey},
                ...{$resourceParams}
                },
            async: true,
            success: function(data) {
                if (data) {
                    $('#' + cardId + '> div > h1').text(data.currentValue);
                    $('#' + cardId + '> div > h5').text(data.previousValue);
                    $('#spinner-' + cardId).addClass('d-none');
                }
            },
        });
    }
</script>
EOD;
    }

}
