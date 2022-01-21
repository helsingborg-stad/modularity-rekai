<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_61eaa5feb2601',
    'title' => __('RekAI Settings', 'modularity-rekai'),
    'fields' => array(
        0 => array(
            'key' => 'field_61eaa6920e638',
            'label' => __('Script url', 'modularity-rekai'),
            'name' => 'rekai_script_url',
            'type' => 'url',
            'instructions' => __('Add your RekAI Script url here, eg: https://static.rekai.se/[nnnn].js', 'modularity-rekai'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'modularity-rekai-settings',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}