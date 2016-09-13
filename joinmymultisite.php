<?php
/*
Plugin Name: Join My Multisite
Plugin URI: http://halfelf.org/plugins/join-my-multisite/
Description: Allow logged in users to add themselves to sites (or auto-add them to all sites). <strong>Settings are per-site, under the Users menu</strong>.
Version: 1.8
Author: Mika Epstein (Ipstenu)
Author URI: http://halfelf.org/
Network: true
Text Domain: join-my-multisite

	Copyright 2012-2016 Mika Epstein (email: ipstenu@halfelf.org)

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

$exit_msg_multisite = 'This plugin only functions on WordPress Multisite.';
if( !is_multisite() ) { exit($exit_msg_multisite); }

// My Defines
require_once dirname(__FILE__) . '/admin/defines.php';

class JMM {

	/**
	 * Plugin Construct
	 *
	 * @since 1.8
	 * @access public
	 */
	public function __construct() {
		// Registers our widget.
		function jmm_load_add_user_widgets() {
		    include_once( JMM_PLUGIN_DIR . '/lib/widget.php');
		}
		
		// This is what controls how people get added.
		$jmm_options = get_option( 'helfjmm_options' );
		if ($jmm_options['type'] == 1) { add_action('init', array('JMM','join_site')); }
		if ($jmm_options['type'] == 2) { add_action( 'widgets_init', 'jmm_load_add_user_widgets' ); }
		
		// Shortcode
		include_once( JMM_PLUGIN_DIR . '/lib/shortcode.php');
		
		add_filter('plugin_row_meta', array( &$this, 'donate_link'), 10, 2);
		add_action('admin_menu', array( &$this, 'add_settings_page'), 10, 2);
		add_action('jmm_joinsite', array( &$this, 'join_site'), 10, 2);
		//add_action('plugins_loaded', array( &$this, 'init'), 10, 2);
	}

	/**
	 * Donate Link
	 *
	 * @since 1.0
	 * @access public
	 */
    public static function donate_link($links, $file) {
        if ($file == plugin_basename(__FILE__)) {
                $donate_link = '<a href="https://store.halfelf.org/donate/">Donate</a>';
                $links[] = $donate_link;
        }
        return $links;
    }

	/**
	 * Add Settings Page
	 *
	 * @since 1.0
	 * @access public
	 */
	public static function add_settings_page() {
        global $jmm_settings_page;
        $jmm_settings_page = add_users_page(__('Join My Multisite Settings','join-my-multisite'), __('Join My Multisite','join-my-multisite'), 'manage_options', 'jmm', array('JMM', 'settings_page'));
    	}
    	
	/**
	 * Settings Page Content
	 *
	 * @since 1.0
	 * @access public
	 */
	public static function settings_page() {
	   // Main Settings
		include_once( JMM_PLUGIN_DIR . '/admin/settings.php');
	}
	
	/**
	 * Join Site code
	 *
	 * @since 1.0
	 * @access public
	 */
    static function join_site( ) {
        global $current_user, $blog_id;
        
        $jmm_options = get_option( 'helfjmm_options' );
    
        if(!is_user_logged_in())
        return false;
     
        if( !is_user_member_of_blog() ) {
            add_user_to_blog($blog_id, $current_user->ID, $jmm_options['role']);
        }
    }

}

new JMM();

// Why are you still reading this? Do you want a cookie?