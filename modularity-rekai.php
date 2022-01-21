<?php

/**
 * Plugin Name:       Modularity RekAI
 * Plugin URI:        https://github.com/helsingborg-stad/modularity-rekai
 * Description:       Display RekAI recommended
 * Version:           1.0.0
 * Author:            Sebastian Thulin
 * Author URI:        https://github.com/sebastianthulin
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       mod-rekai
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('MODULARITYREKAI_PATH', plugin_dir_path(__FILE__));
define('MODULARITYREKAI_URL', plugins_url('', __FILE__));
define('MODULARITYREKAI_TEMPLATE_PATH', MODULARITYREKAI_PATH . 'templates/');
define('MODULARITYREKAI_VIEW_PATH', MODULARITYREKAI_PATH . 'views/');
define('MODULARITYREKAI_MODULE_VIEW_PATH', plugin_dir_path(__FILE__) . 'source/php/Module/views');
define('MODULARITYREKAI_MODULE_PATH', MODULARITYREKAI_PATH . 'source/php/Module/');

load_plugin_textdomain('modularity-rekai', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once MODULARITYREKAI_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once MODULARITYREKAI_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new ModularityRekAI\Vendor\Psr4ClassLoader();
$loader->addPrefix('ModularityRekAI', MODULARITYREKAI_PATH);
$loader->addPrefix('ModularityRekAI', MODULARITYREKAI_PATH . 'source/php/');
$loader->register();

// Acf auto import and export
$acfExportManager = new \AcfExportManager\AcfExportManager();
$acfExportManager->setTextdomain('modularity-rekai');
$acfExportManager->setExportFolder(MODULARITYREKAI_PATH . 'source/php/AcfFields/');
$acfExportManager->autoExport(array(
    'recommended' => 'group_61ea7a87e8e9f',
));
$acfExportManager->import();

// Modularity 3.0 ready - ViewPath for Component library
add_filter('/Modularity/externalViewPath', function ($arr) {
    $arr['mod-rekai'] = MODULARITYREKAI_MODULE_VIEW_PATH;
    return $arr;
}, 10, 3);

// Start application
new ModularityRekAI\App();
