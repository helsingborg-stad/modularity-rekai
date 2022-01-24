@if (!$hideTitle)
    @typography([
        'element' => "h2",
    ])
        {{ $postTitle }}
    @endtypography
@endif

@if($enableRekAI)
    <div id="{{$recommendUid}}" class="mod-recommend__items">
        @if($recommendLinkList) 
            @foreach($recommendLinkList as $recommendLink)
                @include('partials.button', [
                    "text" => $recommendLink->recommendLinkLabel,
                    "href" => $recommendLink->recommendTarget,
                    "type" => "static",
                ])
            @endforeach
        @endif
    </div>
    <script>
        window.addEventListener("load", function(){
            function renderHtml(data) {
                
                let s = '';
                let targetId = document.getElementById("{{$recommendUid}}");
                
                if(targetId) {
                    for(var i = 0; i < data.predictions.length; i++) {
                        s = '<?php echo modularity_recommend_render_blade_view("partials.button", ["href"=> "{MOD_RECOMMEND_HREF}", "text" => "{MOD_RECOMMEND_TITLE}", "type" => "dynamic"]); ?> ';
                    
                        s = s.replace("{MOD_RECOMMEND_HREF}", data.predictions[i].url); 
                        s = s.replace("{MOD_RECOMMEND_TITLE}", data.predictions[i].title); 

                        targetId.insertAdjacentHTML("beforeend", s);
                    }
                }
            }
            window.__rekai.predict({
                overwrite: {
                    addcontent: true,
                    userootpath: false, //Change to true in prod
                    nrofhits: {{$rekaiNumberOfRecommendation}},
                }
            }, renderHtml);
        });
    </script>
@else
    @if($recommendLinkList) 
        @foreach($recommendLinkList as $recommendLink)
            @include('partials.button', [
                "text" => $recommendLink->recommendLinkLabel,
                "href" => $recommendLink->recommendTarget,
                "type" => "static",
            ])
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