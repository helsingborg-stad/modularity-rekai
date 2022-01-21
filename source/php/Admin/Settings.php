<?php

namespace ModularityRekAI\Admin;

/**
 * Class RekAI
 * @package ModularityRekAI
 */
class Settings
{
    public function __construct() {
        add_action('acf/init', array($this, 'registerSettings'));
    }

    /**
     * Register settings
     * @return void
     */
    public function registerSettings()
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(array(
                'page_title'  => _x("RekAI", "ACF", 'modularity-rekai'),
                'menu_title'  => __("RekAI", "RekAI", 'modularity-rekai'),
                'menu_slug'   => 'modularity-rekai-settings',
                'parent_slug' => 'options-general.php',
                'capability'  => 'manage_options'
            ));
        }
    }
}
