<div id="{{$recommendUid}}" class="o-grid">
      @if($recommendLinkList)
            @foreach($recommendLinkList as $recommendLink)
                @include('partials.card', [
                    "text" => $recommendLink->recommendLinkLabel,
                    "href" => $recommendLink->recommendLinkTarget,
                    "type" => "static",
                ])
            @endforeach
      @endif

      <!-- Preloader -->
      @if($enableRekAI)
        @include('partials.card-preload', [
            'rekaiNumberOfRecommendation' => $rekaiNumberOfRecommendation
        ])
      @endif

      @if(!$enableRekAI && !$recommendLinkList)
        @include('partials.notice')
      @endif
</div>
