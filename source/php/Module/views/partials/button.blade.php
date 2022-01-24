@button([
    'text' => $text,
    'style' => 'outlined',
    'color' => 'primary',
    'href' => $href,
    'size' => 'sm',
    'context' => ['module.recommend', 'module.recommend.button'],
    'classList' => [
        'rek-ai-linklist__item', 
        'rek-ai-linklist__' . $type . '-item'
    ],
])
@endbutton