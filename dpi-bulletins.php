<?php

/*
Plugin Name: DPI Bulletins
Plugin URI: http://www.diocesan.com
Description: Provides a quick method of auto generating links to church bulletins
Version: 3.7
Author: Diocesan
Author URI: http://www.diocesan.com
License: GPLv2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

// constants
define('DPI_BULLETINS_ROOT', __FILE__);
define('DPI_BULLETINS_DIR', __DIR__);
define('DPI_BULLETINS_VER', '3.7');
define('DPI_BULLETINS_PLUGIN', plugin_basename( __FILE__ ) );

// autoload plugin classes
require DPI_BULLETINS_DIR . '/psr4-autoloader.php';

// initialize
add_action('init', function() {
	
	$plugin = Bulletins\Plugin\Controller::getInstance();
	$plugin->init();
	
}, 0);

// Check for updates
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

require DPI_BULLETINS_DIR . '/plugin-updates/plugin-update-checker.php';

$myUpdateChecker = PucFactory::buildUpdateChecker(

	'https://github.com/DiocesanInc/DPI-Bulletins',

	DPI_BULLETINS_DIR . '/dpi-bulletins.php',

	'dpi-bulletins'

);

// Set branch
$myUpdateChecker->setBranch('main');
