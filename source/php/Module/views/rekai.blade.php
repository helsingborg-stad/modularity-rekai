@card([
    'context' => 'module.rekai'
])
    <div class="c-card__body">
        @if (!$hideTitle)
            @typography([
                'element' => "h2",
                'classList' => ['c-card__heading'],
            ])
                {{ $postTitle }}
            @endtypography
        @endif

        <div class="rek-ai-linklist u-margin__top--2">
            @if($rekaiLinkList)
                @foreach($rekaiLinkList as $rekaiLink)
                    @button([
                        'text' => $rekaiLink->rekaiLinkLabel,
                        'color' => 'primary',
                        'style' => 'filled',
                        'href' => $rekaiLink->rekaiTarget,
                        'size' => 'sm',
                        'context' => ['module.rekai'],
                        'classList' => [
                            'rek-ai-linklist__item', 
                            'rek-ai-linklist__static-item'
                        ],
                    ])
                    @endbutton
                @endforeach
            @else
                <!-- Rek AI: No static Links-->
            @endif
        </div>

        <div class="rek-prediction"></div>

    </div>
@endpaper