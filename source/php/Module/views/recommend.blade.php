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
                    "href" => $recommendLink->recommendLinkTarget,
                    "type" => "static",
                ])
            @endforeach
        @endif

        <!-- Preloader -->
        @include('partials.preload', [
            'rekaiNumberOfRecommendation' => $rekaiNumberOfRecommendation
        ])
    </div>
    <script>
        window.addEventListener("load", function(){
            function renderHtml(data) {
                
                let s = '';
                let targetId = document.getElementById("{{$recommendUid}}");
                
                if(targetId) {

                    //Remove the preloader
                    let preloaderItems = targetId.querySelectorAll(".u-preloader");
                    if(preloaderItems) {
                        preloaderItems.forEach(function(item) {
                            item.remove();
                        });
                    }

                    //Append content
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
                    userootpath: true,
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
                "href" => $recommendLink->recommendLinkTarget,
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