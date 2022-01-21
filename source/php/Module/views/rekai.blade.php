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
            
        </div>

        @if($rekaiEnableAiSuggest)
            <div class="rek-prediction" data-userootpath="false" data-nrofhits="{{ $rekaiNumberOfRecommendation }}"></div>
        @else
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
                @notice([
                    'type' => 'info',
                    'message' => [
                        'text' => $lang->noData,
                    ],
                    'icon' => [
                        'name' => 'report',
                        'size' => 'md',
                        'color' => 'white'
                    ]
                ])
                @endnotice
            @endif
        @endif

    </div>
@endpaper


<div class="output">OUTPUR</div>

<script>
    window.addEventListener("load", function(){
        function renderHtml(data) {
            var s = '';
            for(var i = 0; i < data.predictions.length; i++) {
                s += '<?php echo modularity_recommend_render_blade_view("partials.button", ["href"=> "' + data.predictions[i].url + '", "text" => "' + data.predictions[i].title + '"]); ?>';
            }
            $('.output').html(s);
        }

        window.__rekai.predict({
            overwrite: {
                addcontent: true
            }
        }, renderHtml);
    });
</script>