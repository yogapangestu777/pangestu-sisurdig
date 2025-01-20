@foreach ($mostFrequentLetterParty as $item)
    <div class="card-inner">
        <div class="nk-wg-action">
            <div class="nk-wg-action-content">
                <em class="icon ni ni-users"></em>
                <div class="title most-dataset-title-{{ $item->id }}">
                    {{ $item->name }}
                </div>
                <p>
                    <span class="most-dataset-amount-{{ $item->id }}">
                        {{ $item->amount }}
                    </span>
                    Surat
                </p>
            </div>
        </div>
    </div>
@endforeach
