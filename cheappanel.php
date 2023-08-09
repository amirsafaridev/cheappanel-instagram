<?php
/**
 * Plugin Name: Arta Cheappanel
 * Description:
 * Version: 1.0.0
 * Author: ArtaCode
 * Author URI: http://artacode.net
 */


defined( 'ABSPATH' ) || exit;

if ( ! defined( 'CHEAPPANEL_PLUGIN_DIR' ) ) {
    define( 'CHEAPPANEL_PLUGIN_FILE', __FILE__ );
    define( 'CHEAPPANEL_PLUGIN_DIR', untrailingslashit( dirname( CHEAPPANEL_PLUGIN_FILE ) ) );
}

// Autoloader File
require __DIR__ . '/includes/main.php';

