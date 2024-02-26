<?php

namespace ModularityRecommend;

use ModularityRecommend\Helper\CacheBust;

class App
{
    public function __construct()
    {

        //Init subset
        new Admin\Settings();

        //Register module
        add_action('plugins_loaded', array($this, 'registerModule'));

        //Add global rek ai script
        add_action('wp_enqueue_scripts', array($this, 'registerRekAIScript'));

        //Add warning
        add_action('admin_head', array($this, 'addUndefinedWarning'));

        //Head
        add_action('wp_head', array($this, 'printMetaTag'));

        //Remove rek ai field, if not enabled
        add_filter("acf/prepare_field/name=rekai_number_of_recommendation", array($this, 'hideRekAIField'));

        add_filter('acf/load_field/key=field_628c958c693a9', array($this, 'hideRekAIOptions'));
    }

    public function hideRekAIField($field)
    {
        if (get_field('rekai_enable', 'options') == false) {
            return false;
        }
        return $field;
    }

    /**
     * Console log undefined warning
     * @return void
     */
    public function addUndefinedWarning()
    {
        if (get_field('rekai_enable', 'options') && empty(get_field('rekai_script_url', 'option'))) {
            echo '
                <script>
                    console.log("RekAI script url is not defined. Please fill it out in the settings tab or disable rekai recommendations.");
                </script>
            ';
        }
    }

    /**
     * Public meta tag. Enables indexing.
     */
    public function printMetaTag()
    {
        echo '<meta name="rek_viewclick" />' . "\n";
    }

    /**
     * Enqueue script
     */
    public function registerRekAIScript()
    {
        $scriptUrl = get_field('rekai_script_url', 'option');

        if ($scriptUrl) {
            wp_register_script(
                'modularity-recommend-stats',
                $scriptUrl,
                null,
                '1.0.0'
            );
            wp_enqueue_script('modularity-recommend-stats');
        }
    }

    /**
     * Register the module
     * @return void
     */
    public function registerModule()
    {
        if (function_exists('modularity_register_module')) {
            modularity_register_module(
                MODULARITYRECOMMEND_MODULE_PATH,
                'Recommend'
            );
        }
    }

    /**
     * Conditionally show field if RekAI is enabled
     *
     * @param array  $field
     * @return array $field
     */
    public function hideRekAIOptions($field)
    {
        if (get_field('rekai_enable', 'options') == false) {
            $field['wrapper']['class'] = 'hidden';
        }

        return $field;
    }
}
