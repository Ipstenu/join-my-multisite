<?php
/*
    This file is part of Join My Multisite, a plugin for WordPress.

    Join My Multisite is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    Join My Multisite is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WordPress.  If not, see <http://www.gnu.org/licenses/>.

*/

if (!defined('ABSPATH')) {
    die();
}

define( 'JMM', true);

defined('PLUGIN_DIR') || define('PLUGIN_DIR', realpath(dirname(__FILE__) . '/..'));

/* 
    Widgets
*/

// Registers our widget.
function jmm_load_add_user_widgets() {
    include_once( PLUGIN_DIR . '/lib/widget.php');
}

// This is what controls how people get added.
    $jmm_options = get_option( 'helfjmm_options' );
    if ($jmm_options['type'] == 1) { add_action('init', array('JMM','join_site')); }
    if ($jmm_options['type'] == 2) { add_action( 'widgets_init', 'jmm_load_add_user_widgets' ); }

// Shortcode
include_once( PLUGIN_DIR . '/lib/shortcode.php');

// The Help Screen
function jmm_plugin_help() {
	include_once( PLUGIN_DIR . '/admin/help.php' );
}
add_action('contextual_help', 'jmm_plugin_help', 10, 3);

// Actions and Filters

add_filter('plugin_row_meta', array('JMM', 'donate_link'), 10, 2);
add_action('admin_menu', array('JMM', 'add_settings_page'));
add_action('jmm_joinsite', array('JMM', 'join_site'));
add_action('init', array('JMM', 'init'));