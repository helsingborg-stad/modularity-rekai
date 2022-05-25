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
      @if($enableRekAI)
        @include('partials.button-preload', [
            'rekaiNumberOfRecommendation' => $rekaiNumberOfRecommendation
        ])
      @endif

      @if(!$enableRekAI && !$recommendLinkList)
        @include('partials.notice')
      @endif
</div>
