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
function jmm_activate_user( $user_id, $password, $meta ) {
    add_user_to_blog( $blog_id, $user_id, get_option( 'default_user_role' ) );
}
add_action( 'wpmu_activate_user', 'jmm_activate_user', 10, 3 );

// Redirect wp-signup.php
function jmm_signup_location($val) {
	$jmm_options = get_option( 'helfjmm_options' );
	if ( !is_null($jmm_options['perpage']) && $jmm_options['perpage'] != "XXXXXX"  )
		{ return get_permalink($jmm_options['perpage']); }
	return $val;
}
//add_filter('wp_signup_location', 'jmm_signup_location');

/* Register shortcodes */
add_action( 'init', 'jmm_add_shortcodes' );
function jmm_add_shortcodes() {
    add_shortcode( 'join-my-multisite', 'jmm_shortcode_func' );
}

// [join-my-multisite] - no params
function jmm_shortcode_func( $atts, $content = null ) {
    global $wp_query;
    add_action( 'wp_head', 'wp_no_robots' );
    $wp_query->is_404 = false;
    include_once( PLUGIN_DIR. '/lib/signuppage.php');
}

// [join-this-site] - no params
function jmm_shortcode_thissite_func( $atts, $content = null ) {
    $jmm_options = get_option( 'widget_helf-add-user-widget' );
    
?>
    <form action="?jmm-join-site" method="post" id="notmember">
    <input type="hidden" name="action" value="jmm-join-site">
    <input type="submit" value="<?php $jmm_options['notmember'] ?>" name="join-site" id="join-site" class="button">
    </form>
<?php
}