<?php
/*
Plugin Name: Join My Multisite
Plugin URI: http://halfelf.org/plugins/join-my-multisite/
Description: Allow logged in users to add themselves to sites (or auto-add them to all sites).
Version: 1.0
Author: Mika Epstein (Ipstenu)
Author URI: http://ipstenu.org/
Network: true

Copyright 2012 Mika Epstein (email: ipstenu@ipstenu.org)

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

// This is what controls how people get added.
    $jmm_options = get_option( 'helfjmm_options' );

    if ($jmm_options['type'] == 1) {add_action('init','jmm_joinsite');}
    if ($jmm_options['type'] == 2) { add_action( 'widgets_init', 'jmm_load_add_user_widgets' ); }


class JMM {

    function init() {
        $jmm_options = get_option( 'helfjmm_options' );
		if ( isset($_GET['settings-updated']) && ( $_GET['page'] ==
'jmm' ) ) { 
            add_action('admin_notices', array('JMM','updateMessage'));
            if ( $jmm_options['role'] != get_option( 'default_user_role' ) )
                { update_option(default_user_role, $jmm_options['role']); }
        }
        
        if ( !isset($jmm_options['type']) ) {
        	$jmm_options['type'] = '3'; // 3 = keep things the same
        	$jmm_options['role'] = 'subscriber'; // You know what this is
        	update_option('jmm_options', $jmm_options);
        }
    }

    // Messages, used by INIT
	function updateMessage() {
		echo "<div id='message' class='updated fade'><p><strong>".__('Options Updated!', helfjmm)."</strong></p></div>";
		}


    // donate link on manage plugin page
    function donate_link($links, $file) {
        if ($file == plugin_basename(__FILE__)) {
                $donate_link = '<a href="https://www.wepay.com/donations/halfelf-wp">Donate</a>';
                $links[] = $donate_link;
        }
        return $links;
    }

	// Return the filesystem path that the plugin lives in.
	function getPath() {
		return dirname(__FILE__) . '/';
	}
 
    // Settings Pages
    function add_settings_page() {
        load_plugin_textdomain(helfjmm, JMM::getPath() . 'i18n');
        global $jmm_settings_page;
        $jmm_settings_page = add_users_page(__('Join My Multisite Settings'), __('Join My Multisite'), 'manage_options', 'jmm', array('JMM', 'settings_page'));
    	}
 
    // Register and define the settings

    function settings_page() {
    // Main Settings
    ?>
    <div class="wrap">
        <div id="icon-users" class="icon32"><br></div>
        <h2><?php _e("Join My Multisite Settings", helfjmm); ?></h2>
        
        <?php 
        $jmm_options = get_option( 'helfjmm_options' );    
        ?>
    
        <form method="post" action="options.php">
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="helfjmm_options" />
            <?php wp_nonce_field('update-options'); ?>
    
            <p><?php _e('Select a membership type and a default role.', helfjmm); ?></p>
            
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e('Membership:', helfjmm); ?></th>
                        <td><input type="radio" name="helfjmm_options[type]" value="1" <?php if ($jmm_options['type'] == 1) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('Auto:', helfjmm); ?></strong> <?php _e('Auto-Add signed in users to this site when they visit.', helfjmm); ?></label><br />
                            <input type="radio" name="helfjmm_options[type]" value="2" <?php if ($jmm_options['type'] == 2) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('Manual:', helfjmm); ?></strong> <?php _e('Allow signed in users to join via a widget', helfjmm); ?></label><br />
                            <input type="radio" name="helfjmm_options[type]" value="3" <?php if ($jmm_options['type'] == 3) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('None:', helfjmm); ?></strong> <?php _e('Don\'t allow new users to add themselves this site, add them manually', helfjmm); ?></label>
                        </td>
                    </tr>
    
                <tr>
                        <th scope="row"><?php _e('New User Default Role:', helfjmm); ?></th>
                        <td>
                        <select name="helfjmm_options[role]" id="<?php echo $jmm_options['role']; ?>">
                        <option value="none"><?php _e( '-- None --', 'helfjmm' )?></option>
                        <?php wp_dropdown_roles( get_option( 'default_user_role' ) ); ?>
                        </select>
                        </td>
                    </tr>
    
            </tbody>
            </table>
            
            <p class="submit"><input class='button-primary' type='Submit' name='update' value='<?php _e("Update Options", helfjmm); ?>' id='submitbutton' /></p>
    
        </form>
    <?php
    }

    // Add users
    function join_site( ) {
        global $current_user, $blog_id;
        
        $jmm_options = get_option( 'helfjmm_options' );
    
        if(!is_user_logged_in())
        return false;
     
        if( !is_blog_user() ) {
            add_user_to_blog($blog_id, $current_user->ID, $jmm_options['role']);
        }
    }


}

/* All this is the widget stuff */

// Function that registers our widget.
function jmm_load_add_user_widgets() {
    register_widget( 'jmm_Add_User_Widget' );
}

// This is the widget!
class jmm_Add_User_Widget extends WP_Widget {

    function jmm_Add_User_Widget() {
		$widget_ops = array( 'classname' => 'jmm_add_users', 'description' => 'Allow members of your network to join a specific site.' );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'helf-add-user-widget' );
		$this->WP_Widget( 'helf-add-user-widget', 'Add Users to Sites Widget', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$notregistered = $instance['notreg'];
		$notmember = $instance['notmember'];
		$member = $instance['member'];
		$welcome = $instance['welcome'];
		global $current_user, $blog_id;
   		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

			if( isset($_POST['jmm-join-site']) || isset($_POST['join-site']) ){
                // This is the magic sauce.
                jmm_joinsite();
                echo $welcome;
            } else {
                if(!is_user_logged_in() && get_option('users_can_register') ) {
                    // If user isn't logged in but we allow for registration....
                    echo $notregistered;
                } elseif( !is_blog_user() ) {
                    // If user IS logged in, then let's invite them to play.
                    echo '<form action="?jmm-join-site" method="post" id="notmember">';
                    echo '<input type="hidden" name="action" value="jmm-join-site">';
                    echo '<input type="submit" value="'.$notmember.'" name="join-site" id="join-site" class="button">';
                    echo '</form>';
                } else {
                    // Otherwise we're already a member, hello, mum!
                    echo $member;
                }
        
            }        
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['notreg'] = strip_tags( $new_instance['notreg'] );
		$instance['notmember'] = strip_tags( $new_instance['notmember'] );
		$instance['member'] = strip_tags( $new_instance['member'] );
		$instance['welcome'] = strip_tags( $new_instance['welcome'] );

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'notreg' => 'Signup for an account!', 'notmember' => 'Join this site!', 'member' => 'Nice to see you again.', 'welcome' => 'Hi, new member!' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'notreg' ); ?>">Not registered on the network:</label>
			<input id="<?php echo $this->get_field_id( 'notreg' ); ?>" name="<?php echo $this->get_field_name( 'notreg' ); ?>" value="<?php echo $instance['notreg']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'notmember' ); ?>">Not a member of this site:</label>
			<input id="<?php echo $this->get_field_id( 'notmember' ); ?>" name="<?php echo $this->get_field_name( 'notmember' ); ?>" value="<?php echo $instance['notmember']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'member' ); ?>">Existing members:</label>
			<input id="<?php echo $this->get_field_id( 'member' ); ?>" name="<?php echo $this->get_field_name( 'member' ); ?>" value="<?php echo $instance['member']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'welcome' ); ?>">Welcome to new member:</label>
			<input id="<?php echo $this->get_field_id( 'welcome' ); ?>" name="<?php echo $this->get_field_name( 'welcome' ); ?>" value="<?php echo $instance['welcome']; ?>" style="width:90%;" />
		</p>
<?php 
		}
}


// Actions and Filters

add_filter('plugin_row_meta', array('JMM', 'donate_link'), 10, 2);
add_action('admin_menu', array('JMM', 'add_settings_page'));
add_action('jmm_joinsite', array('JMM', 'join_site'));
add_action('init', array('JMM', 'init'));