<?php
/*
 * Plugin Name: LB Migration
 * Description: Migrate data from a TXT file to Wordpress enviornment
 * Version: 1.0.0
 * Author: Lucas Bacciotti Moreira
 * Author URI: https://profiles.wordpress.org/baciotti/
 * License: GPLv2 or later
*/

use LBM\Plugin;
use LBM\Shortcode;

require_once "autoload.php";

add_action('plugins_loaded', 'lbm_init');
function lbm_init()
{
    $plugin = new Plugin();
    $plugin['path'] = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR;
    $plugin['url'] = plugin_dir_url(__FILE__);
    $plugin['version'] = '1.0.0';
    $plugin['settings_page_properties'] = array(
        'option_name' => 'lbm_option_name'
    );

    $plugin['shortcode'] = function ($plugin) {
        return new Shortcode($plugin['settings_page_properties']);
    };

    $plugin->run();
}