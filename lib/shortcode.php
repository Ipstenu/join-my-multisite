<?php
/*

    This file is part of Join My Multisite, a plugin for WordPress.

    Join My Multisite is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    Sitewide Comment Control is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WordPress.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('ABSPATH')) {
    die();
}

/* The registration magic */
function jmm_activate_user( $user_id, $password, $meta )
  {add_user_to_blog( $blog_id, $user_id, get_option( 'default_user_role' ) );}
  add_action( 'wpmu_activate_user', 'jmm_activate_user', 10, 3 );

/* Register shortcodes */
add_action( 'init', 'jmm_add_shortcodes' );
function jmm_add_shortcodes() {
    add_shortcode( 'join-my-multisite', 'jmm_shortcode_func' );
}

// [join-my-multisite] - no params

function jmm_shortcode_func( $atts, $content = null ) {

    add_action( 'wp_head', 'wp_no_robots' );
    $wp_query->is_404 = false;    
    include_once( PLUGIN_DIR. '/lib/signuppage.php');

}