<div class="{{ $cardWidth }} px-2">
<div class="card px-0 rounded-lg shadow-sm">
    <div class="card-body px-1 py-2">
        <div class="row px-3">
            <div class="{{ count($ranges) ? 'col-6' : 'col-12' }}">
                <div id="spinner-{{ $cardId }}" class="spinner-border spinner-border-sm d-none" role="status">
                </div>
                <strong>{{ $title }}</strong>
            </div>

            @if(count($ranges))
            <div class="col-6">
                {{ Form::select('range', $ranges, request('range'), ['class' => 'custom-select custom-select-sm', 'onchange' => "loadCardData_{$cardId}('$uriKey', '$cardId')", 'id' => 'select-'.$cardId]) }}
            </div>
            @endif
        </div>

        <div id="{{ $cardId }}" class="row mx-2" style="height: 100px">
            {!! $content !!}
        </div>
    </div>

    {!! $contentScript !!}
</div>
</div>

