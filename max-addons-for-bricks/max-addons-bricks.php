<?php
/**
 * Plugin Name: Max Addons for Bricks
 * Plugin URI: https://www.bloompixel.com
 * Description: Extend Bricks Page Builder with 20+ Creative Elements and exciting extensions.
 * Version: 1.7.2
 * Author: BloomPixel
 * Author URI: https://www.bloompixel.com/about/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: max-addons-for-bricks
 */

/**
 * Copyright (c) 2021 BloomPixel. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 */

// * Prevent direct access to the plugin
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'Sorry, you are not allowed to access this page directly.', 'max-addons-for-bricks' ) );
}

// * Define constants
define( 'MAB_VER', '1.7.2' );
define( 'MAB_DIR', plugin_dir_path( __FILE__ ) );
define( 'MAB_BASE', plugin_basename( __FILE__ ) );
define( 'MAB_URL', plugins_url( '/', __FILE__ ) );

require_once MAB_DIR . 'classes/class-mab-plugin.php';
