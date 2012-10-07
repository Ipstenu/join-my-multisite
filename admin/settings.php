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
 
    // Register and define the settings
?>
    <div class="wrap">
        <div id="icon-users" class="icon32"><br></div>
        <h2><?php _e("Join My Multisite Settings", 'helfjmm'); ?></h2>
        
        <?php 
        $jmm_options = get_option( 'helfjmm_options' );    
        ?>
    
        <form method="post" action="options.php">
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="helfjmm_options" />
            <?php wp_nonce_field('update-options'); ?>
    
            <p><?php _e('Select a membership type and a default role.', 'helfjmm'); ?></p>
            
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e('Membership:', 'helfjmm'); ?></th>
                        <td><input type="radio" name="helfjmm_options[type]" value="1" <?php if ($jmm_options['type'] == 1) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('Auto:', 'helfjmm'); ?></strong> <?php _e('Auto-Add signed in users to this site when they visit.', 'helfjmm'); ?></label><br />
                            <input type="radio" name="helfjmm_options[type]" value="2" <?php if ($jmm_options['type'] == 2) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('Manual:', 'helfjmm'); ?></strong> <?php _e('Allow signed in users to join via a widget.', 'helfjmm'); ?></label><br />
                            <input type="radio" name="helfjmm_options[type]" value="3" <?php if ($jmm_options['type'] == 3) echo 'checked="checked"'; ?>> <label for="jmm-type"><strong><?php _e('None:', 'helfjmm'); ?></strong> <?php _e('Don\'t allow new users to add themselves this site, add them manually.', 'helfjmm'); ?></label>
                        </td>
                    </tr>
    
                <tr>
                        <th scope="row"><?php _e('New User Default Role:', 'helfjmm'); ?></th>
                        <td>
                        <select name="helfjmm_options[role]" id="<?php echo $jmm_options['role']; ?>">
                        <option value="none"><?php _e( '-- None --', 'helfjmm' )?></option>
                        <?php wp_dropdown_roles( get_option( 'default_user_role' ) ); ?>
                        </select>
                        </td>
                    </tr>
    
            </tbody>
            </table>
            
            <p class="submit"><input class='button-primary' type='Submit' name='update' value='<?php _e("Update Options", 'helfjmm'); ?>' id='submitbutton' /></p>
    
        </form>

