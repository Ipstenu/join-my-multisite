<?php
/*
Plugin Name: Join My Multisite
Plugin URI: http://halfelf.org/plugins/auto-add-multisite/
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

// We're keeping this code for a reason.
function helfjmm_add_users( ) {
    global $current_user, $blog_id;

    if(!is_user_logged_in())
    return false;
 
    if( !is_blog_user() ) {
        add_user_to_blog($blog_id, $current_user->ID, "subscriber");
    }
}

/* 

OPTIONS on the add new user page:

1) Auto-add users to this site

2) Allow logged in users to join via widget

3) Keep things the same (no auto-add, no widget)

You can only have one checked. 

// Register and define the settings
add_action('admin_init', 'helfjmm_admin_init');

function helfjmm_admin_init(){

    add_settings_section(
        'helfjmm_setting_section', 
        'Join My Multisite Settings', 
        'helfjmm_setting_section_callback_function',
        'new-user'
    );


 	// Add the field with the names and function to use for our new
 	// settings, put it in our new section
 	add_settings_field(
 		'helfjmm_setting_basics',
		'Options',
		'helfjmm_setting_basics_callback_function',
		'new-user',
		'helfjmm_setting_section');


	register_setting(
		'discussion',               // settings page
		'ippy_bcq_options',         // option name
		'ippy_bcq_validate_options' // validation callback
	);
	
	add_settings_field(
		'ippy_bcq_bbpress',         // id
		'Quicktags',                // setting title
		'ippy_bcq_setting_input',   // display callback
		'discussion',               // settings page
		'default'                   // settings section
	);
}



Default Role:

Dropdown with the available roles.

wp_dropdown_roles()

    <tr valign="top">
        <th scope="row"><?php _e('Select default role for new users', 'helfjmm'); ?></th>
        <td>
        <select name="helfjmm_default_user_role[<?php echo $blog[ 'blog_id' ]; ?>]" id="helfjmm_default_user_role[<?php echo $blog[ 'blog_id' ]; ?>]">
            <option value="none"><?php _e( '-- None --', 'helfjmm' )?></option>
                <?php wp_dropdown_roles( get_option( 'helfjmm_default_user_role' ) ); ?>
        </select>
        </td>
    </tr>

/*

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'helfjmm_load_add_user_widgets' );

/* if 'allow widget' is checked, then show .... */

    // Function that registers our widget.
    function helfjmm_load_add_user_widgets() {
    	register_widget( 'helfjmm_Add_User_Widget' );
    }

/* This is the widget! */
class helfjmm_Add_User_Widget extends WP_Widget {

    function helfjmm_Add_User_Widget() {
		$widget_ops = array( 'classname' => 'helfjmm_add_users', 'description' => 'Allow members of your network to join a specific site.' );
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

        if (is_ssl()) {
            $schema_ssl = 'https://'; 
        } else { 
            $schema_ssl = 'http://'; 
        }
                		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

			if( isset($_POST['helf-join-site']) || isset($_POST['join-site']) ){
                // This is the magic sauce.			
    			$source = $schema_ssl.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    			$source = substr($source,0, -15);
                helfjmm_add_user();
                echo $welcome;
            } else {
                if(!is_user_logged_in() && get_option('users_can_register') ) {
                    // If user isn't logged in but we allow for registration....
                    echo $notregistered;
                } elseif( !is_blog_user() ) {
                    // If user IS logged in, then let's invite them to play.
                    echo '<form action="?helf-join-site" method="post" id="notmember">';
                    echo '<input type="hidden" name="action" value="helf-join-site">';
                    echo '<input type="submit" value="'.$notmember.'" name="join-site" id="join-site" class="button">';
                    echo '</form>';
                } else {
                    // Otehrwise we're already a member, hello, mum!
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