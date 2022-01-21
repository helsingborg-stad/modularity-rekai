<?php

namespace ModularityRekAI\Module;

use ModularityRekAI\Helper\CacheBust;

/**
 * Class RekAI
 * @package RekAI\Module
 */
class RekAI extends \Modularity\Module
{
    public $slug = 'rekai';
    public $supports = array();

    public function init()
    {
        $this->nameSingular = __("RekAI Recommendation", 'modularity-rekai');
        $this->namePlural = __("RekAI Recommendation", 'modularity-rekai');
        $this->description = __("RekAI view for recommendated links.", 'modularity-rekai');
    }

    /**
     * Data array
     * @return array $data
     */
    public function data(): array
    {
        $data = array();

        //Append field config
        $data = array_merge($data, (array) \Modularity\Helper\FormatObject::camelCase(
            get_fields($this->ID)
        ));

        //Translations
        $data['lang'] = (object) array(
        );

        return $data;
    }

    /**
     * Blade Template
     * @return string
     */
    public function template(): string
    {
        return "rekai.blade.php";
    }

    /**
     * Style - Register & adding css
     * @return void
     */
    public function style()
    {
        //Register custom css
        wp_register_style(
            'modularity-rekai',
            MODULARITYREKAI_URL . '/dist/' . CacheBust::name('css/modularity-rekai.css'),
            null,
            '1.0.0'
        );

        //Enqueue
        wp_enqueue_style('modularity-rekai');
    }

    /**
     * Available "magic" methods for modules:
     * init()            What to do on initialization
     * data()            Use to send data to view (return array)
     * style()           Enqueue style only when module is used on page
     * script            Enqueue script only when module is used on page
     * adminEnqueue()    Enqueue scripts for the module edit/add page in admin
     * template()        Return the view template (blade) the module should use when displayed
     */
}
