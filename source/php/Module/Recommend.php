<?php

namespace ModularityRecommend\Module;

use ModularityRecommend\Helper\CacheBust;

/**
 * Class Recommend
 * @package Recommend\Module
 */
class Recommend extends \Modularity\Module
{
    public $slug = 'recommend';
    public $supports = array();

    public function init()
    {
        $this->nameSingular = __("Recommend", 'modularity-recommend');
        $this->namePlural = __("Recommend", 'modularity-recommend');
        $this->description = __("Recommend view for links.", 'modularity-recommend');
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
            $this->getFields()
        ));

        $data['advancedOptions']    = json_encode(!empty($data['rekai']['advancedOptions']) ? $data['rekai']['advancedOptions'] : "null");
        $data['rekaiOptions']       = json_encode([
            'subtree' => !empty($data['rekai']['subtree']) ? $this->convertPostsToString($data['rekai']['subtree']) : "",
            'excludetree' => !empty($data['rekai']['excludetree']) ? $this->convertPostsToString($data['rekai']['excludetree']) : "",
            'userootpath' => !empty($data['rekai']['userootpath']) ? true : false,
            'rootpathlevel' => !empty($data['rekai']['rootpathlevel']) ? (int)$data['rekai']['rootpathlevel'] : null
        ]);

        if(isset($data['recommendColumns']) && is_numeric($data['recommendColumns'])) {
            $data['gridClass'] =  $this->getGridClass((int) $data['recommendColumns']);
        } else {
            $data['gridClass'] = "";
        }

        //Translations
        $data['lang'] = (object) array(
            'noData' => __(
                "No static links provided to recommendation module. AI suggestion is off.",
                'modularity-recommend'
            ),
            'loading' => __(
                "Loading content",
                'modularity-recommend'
            ),
        );

        //Get permalink, reformat to object
        if (!empty($data['recommendLinkList'])) {
            $data['recommendLinkList'] = array_map(function ($item) {
                $item['recommendIsExternal'] = $item['recommendLinkIsExternal'];
                $item['recommendTarget'] = $item['recommendIsExternal']
                    ? $item['recommendLinkTargetExternal']
                    : get_permalink($item['recommendLinkTarget']);
                $item['recommendExcerpt'] = get_the_excerpt($item['recommendLinkTarget']);
                return (object) $item;
            }, $data['recommendLinkList']);
        }

        //Enable RekAI
        $data['enableRekAI'] = get_field('rekai_enable', 'options');

        //Add uid
        $data['recommendUid'] = "prediction-mount-" . md5(rand());

        return $data;
    }

    /**
     * Create a grid column size
     * @param  array $archiveProps
     * @return string
     */
    public function getGridClass(int $columns): string
    {
        $stack = [];
        $stack[] = $this->createGridClass(1);

        if ($columns == 2) {
            $stack[] = $this->createGridClass(2, 'md');
            $stack[] = $this->createGridClass(2, 'lg');
        }

        if ($columns == 3) {
            $stack[] = $this->createGridClass(2, 'md');
            $stack[] = $this->createGridClass(3, 'lg');
        }

        if ($columns == 4) {
            $stack[] = $this->createGridClass(2, 'sm');
            $stack[] = $this->createGridClass(3, 'md');
            $stack[] = $this->createGridClass(4, 'lg');
        }

        return implode(' ', $stack);
    }

    /**
     * Create a grid class
     *
     * @param integer $numberOfColumns  The width of grid
     * @param string  $mediaQuery       Target size
     * @return string
     */
    public function createGridClass($numberOfColumns = 1, $mediaQuery = null)
    {
        $baseColumns = 12;

        if ($numberOfColumns == 0) {
            $numberOfColumns = 1;
        }

        if (is_string($mediaQuery)) {
            $result = "o-grid-" . round($baseColumns / $numberOfColumns) . "@" . $mediaQuery;
        } else {
            $result = "o-grid-" . round($baseColumns / $numberOfColumns);
        }

        return $result;
    }

    /**
     * Converts post names to comma separated string
     * @param array $posts
     * @return string
     */
    public function convertPostsToString(array $posts)
    {
        $string = "";
        foreach ($posts as $post) {
            $string .= $post->post_name . ",";
        }
        return rtrim($string, ",");
    }

    /**
     * Blade Template
     * @return string
     */
    public function template(): string
    {
        return "recommend.blade.php";
    }

    /**
     * Style - Register & adding css
     * @return void
     */
    public function style()
    {
        //Register custom css
        wp_register_style(
            'modularity-recommend',
            MODULARITYRECOMMEND_URL . '/dist/' . CacheBust::name('css/modularity-recommend.css'),
            null,
            '1.0.0'
        );

        //Enqueue
        wp_enqueue_style('modularity-recommend');
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
