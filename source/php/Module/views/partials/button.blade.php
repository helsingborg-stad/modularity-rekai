@button([
    'text' => $text,
    'style' => 'outlined',
    'color' => 'primary',
    'href' => $href,
    'size' => 'sm',
    'context' => ['module.recommend', 'module.recommend.button'],
    'classList' => [
        'recommend-linklist__item',
        'recommend-linklist__' . $type . '-item',
        'c-button--pill',
    ],
    'target' => $external ? '_blank' : null,
    'icon' => $external ? 'open_in_new' : null,
    'ariaLabel' => $external ? sprintf($lang->openInNew, $text) : null,
])
@endbutton
