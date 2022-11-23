@for ($i = 0; $i < $rekaiNumberOfRecommendation; $i++)
  @button([
    'size' => 'sm',
    'text' => $lang->loading,
    'classList' => [
      'u-preloader',
      'recommend-linklist__item',
      'recommend-linklist__preload-item',
      'c-button--pill',
      'rek-ai-preload-remove'
    ],
    'attributeList' => [
      'style' => 'width: ' .rand(80, 250). 'px;'
    ]
  ])
  @endbutton
@endfor
