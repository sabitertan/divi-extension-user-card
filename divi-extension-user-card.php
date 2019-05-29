<?php
/*
Plugin Name: User Card(Divi Extension)
Plugin URI:  https://github.com/sabitertan
Description: This Divi theme extension will show a User Card that pulls information from WP Users.
Version:     1.0.0
Author:      sabit
Author URI:  https://github.com/sabitertan
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: diviusercard-divi-extension-user-card
Domain Path: /languages

User Card(Divi Extension) is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

User Card(Divi Extension) is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with User Card(Divi Extension). If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'diviusercard_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function diviusercard_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/DiviExtensionUserCard.php';
}
add_action( 'divi_extensions_init', 'diviusercard_initialize_extension' );
endif;


add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
    <tr>
            <th><label for="image">Profile Image</label></th>
 
            <td>
                <img src="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>" style="height:50px;">
                <input type="text" name="image" id="image" value="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>" class="regular-text" /><input type='button' class="button-primary" value="Upload Image" id="uploadimage"/><br />
                <span class="description">Please upload your image for your profile.</span>
            </td>
        </tr>
    <tr>
        <th><label for="job_title"><?php _e("Job Title"); ?></label></th>
        <td>
            <input type="text" name="job_title" id="job_title" value="<?php echo esc_attr( get_the_author_meta( 'job_title', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter job title here."); ?></span>
        </td>
    </tr>
	<tr>
        <th><label for="direct_phone"><?php _e("Direct Phone"); ?></label></th>
        <td>
            <input type="text" name="direct_phone" id="direct_phone" value="<?php echo esc_attr( get_the_author_meta( 'direct_phone', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your direct phone."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="address"><?php _e("Address"); ?></label></th>
        <td>
            <input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your address."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="city"><?php _e("City"); ?></label></th>
        <td>
            <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your city."); ?></span>
        </td>
    </tr>
    <tr>
    <th><label for="postalcode"><?php _e("Postal Code"); ?></label></th>
        <td>
            <input type="text" name="postalcode" id="postalcode" value="<?php echo esc_attr( get_the_author_meta( 'postalcode', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your postal code."); ?></span>
        </td>
    </tr>
    </table>
<?php }
add_action('admin_head','my_profile_upload_js');
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox'); 


function my_profile_upload_js() { ?>
    
    <script type="text/javascript">
        jQuery(document).ready(function() {
        
            jQuery(document).find("input[id^='uploadimage']").live('click', function(){
                //var num = this.id.split('-')[1];
                formfield = jQuery('#image').attr('name');
                tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
     
                window.send_to_editor = function(html) {
                    imgurl = jQuery('img',html).attr('src');
                    jQuery('#image').val(imgurl);
                    
                    tb_remove();
                }
     
                return false;
            });
        });
    </script>

<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
	}
	update_user_meta( $user_id, 'direct_phone', $_POST['direct_phone'] );
	update_user_meta( $user_id, 'job_title', $_POST['job_title'] );
    update_user_meta( $user_id, 'address', $_POST['address'] );
    update_user_meta( $user_id, 'city', $_POST['city'] );
    update_user_meta( $user_id, 'postalcode', $_POST['postalcode'] );
    update_usermeta( $user_id, 'image', $_POST['image'] );
}