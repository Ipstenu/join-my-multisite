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
 
// In lieu of options.php....
if( isset($_POST['action']) && $_POST['action'] == 'update' ) {

    $new_options = get_option( 'helfjmm_options' );
        if (isset($_POST['jmm_type'])) $new_options['type'] = $_POST['jmm_type']; 
        if (isset($_POST['jmm_role'])) $new_options['role'] = $_POST['jmm_role'];
        if (isset($_POST['jmm_persite'])) 
            { $new_options['persite'] = $_POST['jmm_persite'];}
            else 
            {$new_options['persite'] = '0';}
        if (isset($_POST['jmm_perpage'])) $new_options['perpage'] = $_POST['jmm_perpage'];
    update_option('helfjmm_options', $new_options);
    update_option( 'default_user_role', $new_options['role']);

    // Echo 
    ?><div id='message' class='updated fade'><p><strong><?php _e('Options Updated!', 'helfjmm'); ?></strong></p></div><?php
}

?>
    <div class="wrap">
        <div id="icon-users" class="icon32"><br></div>
        <h2><?php _e("Join My Multisite Settings", 'helfjmm'); ?></h2>
        
        <?php 
        $jmm_options = get_option( 'helfjmm_options' );    
        ?>
    
        <form method="post" action="">
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="helfjmm_options" />
            <?php wp_nonce_field('update-options'); ?>
    
            <p><?php _e('Select a membership type and a default role.', 'helfjmm'); ?></p>
            
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e('Membership:', 'helfjmm'); ?></th>
                        <td><p>
                            <input type="radio" name="jmm_type" value="1" <?php if ($jmm_options['type'] == 1) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('Automatic', 'helfjmm'); ?></strong> </label><br />
                            <input type="radio" name="jmm_type" value="2" <?php if ($jmm_options['type'] == 2) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('Manual', 'helfjmm'); ?></strong> </label><br />
                            <input type="radio" name="jmm_type" value="3" <?php if ($jmm_options['type'] == 3) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('None', 'helfjmm'); ?></strong></label>
                        </p></td>
                        <td><p class="description">
                        <?php _e('Auto-Add signed in users to this site when they visit.', 'helfjmm'); ?><br />
                        <?php _e('Allow signed in users to join via a widget.', 'helfjmm'); ?><br />
                        <?php _e('Don\'t allow new users to add themselves this site, add them manually.', 'helfjmm'); ?>
                        </p></td>
                    </tr>
                    
                    <?php
                    // Registration Options:
                    
                    if ( get_option('users_can_register') == 1 ):
                    ?>
                    
                    <tr valign="top">
                        <th scope="row"><?php _e('Registration:', 'helfjmm'); ?></th>
                        <td><p>
                            <input type="checkbox" name="jmm_persite" value="1" <?php if ($jmm_options['persite'] == 1) echo 'checked="checked"'; ?>> <label for="jmm-persite"><?php _e('Per-Site', 'helfjmm'); ?></label>
                        </p></td>
                        <td><p class="description"><?php _e('Check this box if you want to use a shortcode to customize per-site registration. If unchecked, registrations will be sent to the network registration page.', 'helfjmm'); ?></p></td>
                    </tr>
                    <?php if ($jmm_options['persite'] == 1) { 
                            $all_pages = get_pages();
                    ?>   
                    <tr valign="top">
                        <th scope="row"></th>
                        <td>
                        <p><select name="jmm_perpage" id='jmm_options[perpage]'>
                            <option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
                            <?php echo walk_page_dropdown_tree( $all_pages, 0, array( 'depth' => 1,'selected' => $jmm_options['perpage'] ) ); ?>
                        </select></p>
                        </td>
                        
                        <td><p class="description"><?php _e('Users who are not logged in will be redirected to the perpage you select from the dropdowns. Only top-level pages may be used. Use the following shortcode to display the login form:', 'helfjmm'); ?><br />
                            <code>[join-my-multisite]</code>
                        </td>
                    </tr>
                    <?php } 
                    
                    endif; // End check for if registration is on for the network.
                    ?>
                    <tr> 
                        <th scope="row"><?php _e('New User Default Role:', 'helfjmm'); ?></th>
                        <td>
                        <select name="jmm_role" id="<?php echo $jmm_options['role']; ?>">
                        <option value="none"><?php _e( '-- None --', 'helfjmm' )?></option>
                        <?php wp_dropdown_roles( get_option( 'default_user_role' ) ); ?>
                        </select>
                        </td>
                    </tr>
    
            </tbody>
            </table>
            
            <p class="submit"><input class='button-primary' type='Submit' name='update' value='<?php _e("Update Options", 'helfjmm'); ?>' id='submitbutton' /></p>
    
        </form>