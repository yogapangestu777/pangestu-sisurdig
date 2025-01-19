<div class="nk-tb-col nk-tb-col-tools">
    <ul class="nk-tb-actions gx-1 my-n1">
        <li>
            <div class="drodown">
                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown"><em
                        class="icon ni ni-more-h"></em></a>
                <div class="dropdown-menu dropdown-menu-end">
                    <ul class="link-list-opt no-bdr">
                        @foreach ($buttons as $btn)
                            @if (!array_key_exists('need-confirmation', $btn))
                                <li>
                                    @if (isset($btn['isModal']))
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#create-modal" data-title="Edit"
                                            data-url="{{ $btn['url'] }}" data-method="put"
                                            @foreach ($btn['isModal']['attr'] as $key => $value)
                                            data-{{ $key }}="{!! $value !!}" @endforeach>
                                            <em class="icon ni ni-{{ $btn['icon'] }}"></em>
                                            {{ $btn['title'] }}
                                        </a>
                                    @else
                                        <a href="{{ $btn['url'] }}">
                                            <em class="icon ni ni-{{ $btn['icon'] }}"></em>
                                            {{ $btn['title'] }}
                                        </a>
                                    @endif
                                </li>
                            @elseif (array_key_exists('need-confirmation', $btn))
                                <li>
                                    <form action="{{ $btn['url'] }}" method="post">
                                        @csrf
                                        @method($btn['method'])
                                        <a href="javascript:void(0)" class="{{ $btn['class'] }}">
                                            <em class="icon ni ni-{{ $btn['icon'] }}"></em>
                                            <span>{{ $btn['title'] }}</span>
                                        </a>
                                    </form>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</div>
