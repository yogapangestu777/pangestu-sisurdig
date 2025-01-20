@foreach ($forCards as $item)
    <div class="col-sm-4 col-xxl-6">
        <a href="{{ $item['url'] }}">
            <div class="nk-order-ovwg-data {{ $item['outline'] }}">
                <div class="amount">
                    <em class="icon ni ni-{{ $item['icon'] }}"></em>
                    <span id="{{ $item['id'] }}">
                        {{ $item['data'] }}
                    </span>
                </div>
                <div class="title">
                    {{ $item['title'] }}
                </div>
            </div>
        </a>
    </div>
@endforeach
