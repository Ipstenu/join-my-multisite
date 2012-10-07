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

// Register the widget
register_widget( 'jmm_JMM_Widget' );

// This is the widget!
class jmm_JMM_Widget extends WP_Widget {

    function jmm_JMM_Widget() {
		$widget_ops = array( 'classname' => 'jmm_add_users', 'description' => 'Allow members of your network to join a specific site.' );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'helf-add-user-widget' );
		$this->WP_Widget( 'helf-add-user-widget', 'Join My Site Widget', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
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
                do_action('jmm_joinsite', array('JMM', 'join_site'));
                echo $welcome;
            } else {
                if( !is_user_logged_in() ) {
                    if ( get_option('users_can_register') == 1 ) {
                         // If user isn't logged in but we allow for registration....
                        echo '<form action="/wp-signup.php" method="post" id="notmember">';
                        echo '<input type="hidden" name="action" value="jmm-join-site">';
                        echo '<input type="submit" value="'.$notregistered.'" name="join-site" id="join-site" class="button">';
                        echo '</form>';
                        // If we don't allow registration, we show nothing.
                    }
                } elseif( !is_user_member_of_blog() ) {
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
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['notreg'] = strip_tags( $new_instance['notreg'] );
		$instance['notmember'] = strip_tags( $new_instance['notmember'] );
		$instance['member'] = strip_tags( $new_instance['member'] );
		$instance['welcome'] = strip_tags( $new_instance['welcome'] );

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Join up!', 'notreg' => 'Signup for an account!', 'notmember' => 'Join this site!', 'member' => 'Nice to see you again.', 'welcome' => 'Hi, new member!' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title:', 'helfjmm' )?></strong></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'notreg' ); ?>"><?php _e( 'Not registered on the network:', 'helfjmm' )?></label>
			<input id="<?php echo $this->get_field_id( 'notreg' ); ?>" name="<?php echo $this->get_field_name( 'notreg' ); ?>" value="<?php echo $instance['notreg']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'notmember' ); ?>"><?php _e( 'Not a member of this site:', 'helfjmm' )?></label>
			<input id="<?php echo $this->get_field_id( 'notmember' ); ?>" name="<?php echo $this->get_field_name( 'notmember' ); ?>" value="<?php echo $instance['notmember']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'member' ); ?>"><?php _e( 'Existing members:', 'helfjmm' )?></label>
			<input id="<?php echo $this->get_field_id( 'member' ); ?>" name="<?php echo $this->get_field_name( 'member' ); ?>" value="<?php echo $instance['member']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'welcome' ); ?>"><?php _e( 'Welcome to new member:', 'helfjmm' )?></label>
			<input id="<?php echo $this->get_field_id( 'welcome' ); ?>" name="<?php echo $this->get_field_name( 'welcome' ); ?>" value="<?php echo $instance['welcome']; ?>" style="width:90%;" />
		</p>
<?php 
		}
}