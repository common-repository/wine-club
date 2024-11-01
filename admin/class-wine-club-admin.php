<?php
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/User.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.domagojfranc.com
 * @since      1.0.0
 *
 * @package    Wine_Club_Connection
 * @subpackage Wine_Club_Connection/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wine_Club_Connection
 * @subpackage Wine_Club_Connection/admin
 * @author     Daedalushouse <andrea@daedalushouse.com>
 */
class Wine_Club_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private $logger;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wine-club-admin.css?v=1.2', array(), '', 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		if(isset($_GET['page'])){
			
			$current_page = sanitize_text_field($_GET['page']);
		
			if($current_page == 'wine-club-bach-orders' || $current_page == 'wine-club-connection' || $current_page == 'wine-club-settings' || $current_page == 'wine-club-shipping-settings') {

				wp_enqueue_script( $this->plugin_name, plugin_dir_url(__FILE__) . 'js/wine-club-admin.js', array( 'jquery' ), $this->version, false );
			}
		}
		
		
	}



	/**
     * Update customer if data changed
     *
     * @param $customer
     *
     * @since 1.0.0
     */
    private function checkForCustomerDataChange($customer)
    {

        $user = get_user_by_email($customer['email_address']);
        if ($user->wc_square_customer_id != $customer['id']) {
            update_user_meta($user->ID, 'wc_square_customer_id', $customer['id']);
        }
        if ($user->billing_email != $customer['email_address']) {
            update_user_meta($user->ID, 'billing_email', $customer['email_address']);
        }
        if ($user->billing_phone != $customer['phone_number']) {
            update_user_meta($user->ID, 'billing_phone', $customer['phone_number']);
        }
        if ($user->billing_address_1 != $customer['address']['address_line_1']) {
            update_user_meta($user->ID, 'billing_address_1', $customer['address']['address_line_1']);
        }
        if ($user->billing_address_2 != $customer['address']['address_line_2']) {
            update_user_meta($user->ID, 'billing_address_2', $customer['address']['address_line_2']);
        }
        if ($user->billing_city != $customer['address']['locality']) {
            update_user_meta($user->ID, 'billing_city', $customer['address']['locality']);
        }
        if ($user->billing_postcode != $customer['address']['postal_code']) {
            update_user_meta($user->ID, 'billing_postcode', $customer['address']['postal_code']);
        }
        if ($user->billing_country != $customer['address']['country']) {
            update_user_meta($user->ID, 'billing_country', $customer['address']['country']);
        }
        if ($user->billing_state != $customer['address']['administrative_district_level_1']) {
            update_user_meta($user->ID, 'billing_state', $customer['address']['administrative_district_level_1']);
        }
        if ($user->billing_company != $customer['company_name']) {
            update_user_meta($user->ID, 'billing_company', $customer['company_name']);
        }
        if ($user->billing_last_name != $customer['family_name']) {
            update_user_meta($user->ID, 'billing_last_name', $customer['family_name']);
        }
        if ($user->billing_first_name != $customer['given_name']) {
            update_user_meta($user->ID, 'billing_first_name', $customer['given_name']);
        }
        if ($user->last_name != $customer['family_name']) {
            update_user_meta($user->ID, 'last_name', $customer['family_name']);
        }
        if ($user->first_name != $customer['given_name']) {
            update_user_meta($user->ID, 'first_name', $customer['given_name']);
        }
    }

    /**
     * Create new customer
     *
     * @param $customer
     *
     * @since 1.0.0
     */
    private function createNewCustomer($customer)
    {
    	$user_id = wp_create_user($customer['email_address'], wp_generate_password($length = 12, $include_standard_special_chars = false), $customer['email_address']);


    	update_user_meta($user_id, 'wc_square_customer_id', $customer['id']);
    	update_user_meta($user_id, 'shipping_last_name', $customer['family_name']);
    	update_user_meta($user_id, 'shipping_first_name', $customer['given_name']);
    	update_user_meta($user_id, 'billing_email', $customer['email_address']);
    	update_user_meta($user_id, 'billing_phone', $customer['phone_number']);
    	update_user_meta($user_id, 'billing_address_1', $customer['address']['address_line_1']);
    	update_user_meta($user_id, 'billing_address_2', $customer['address']['address_line_2']);
    	update_user_meta($user_id, 'billing_city', $customer['address']['locality']);
    	update_user_meta($user_id, 'billing_postcode', $customer['address']['postal_code']);
    	update_user_meta($user_id, 'billing_country', $customer['address']['country']);
    	update_user_meta($user_id, 'billing_state', $customer['address']['administrative_district_level_1']);
    	update_user_meta($user_id, 'billing_company', $customer['company_name']);
    	update_user_meta($user_id, 'billing_last_name', $customer['family_name']);
    	update_user_meta($user_id, 'billing_first_name', $customer['given_name']);
    	update_user_meta($user_id, 'last_name', $customer['family_name']);
    	update_user_meta($user_id, 'first_name', $customer['given_name']);
    	update_user_meta($user_id, 'shipping_company', $customer['company_name']);
    	update_user_meta($user_id, 'shipping_address_1', $customer['address']['address_line_1']);
    	update_user_meta($user_id, 'shipping_address_2', $customer['address']['address_line_2']);
    	update_user_meta($user_id, 'shipping_city', $customer['address']['locality']);
    	update_user_meta($user_id, 'shipping_postcode', $customer['address']['postal_code']);
    	update_user_meta($user_id, 'shipping_country', $customer['address']['country']);
    	update_user_meta($user_id, 'shipping_state', $customer['address']['administrative_district_level_1']);

    }


	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 * Administration Menus: http://codex.wordpress.org/Administration_Menus
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
						
		
		add_menu_page( 'Woocommerce Wine Club Connection membership levels', 'Wine Club Connection', 'manage_woocommerce', $this->plugin_name, array($this, 'adminDisplay'), plugins_url('wine-club/admin/images/winelogo.png'));
		
		
		add_submenu_page($this->plugin_name, 'Club Setup', 'Club Setup', 'manage_woocommerce', $this->plugin_name, array($this, 'adminDisplay'));
	}
	
	 /**
	 * Add settings action link to the plugins page.
    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	 *
	 * @since    1.0.0
	 */
	 public function add_action_links( $links ) {
	 	$settings_link = array(
	 		'<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	 	);
	 	return array_merge(  $settings_link, $links );

	 }

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function adminDisplay() {
		include_once( 'partials/wine-club-admin.php' );
	}

	public function addMembershipLevel() {
		include_once( 'partials/membership/addMembershipLevel.php' );
	}

	/**
	 * Add membership level to general product data
     *
     * @since    1.0.0
	 */
	public function addMembershipLevelToGeneralProductData() {
		global  $post, $wpdb;
		$membershipLevelsObj = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels");

		$membershipLevels[0] = 'Product is not connected to membership level';

		foreach($membershipLevelsObj as $membershipLevel) {
			$membershipLevels[$membershipLevel->id] = $membershipLevel->name;
		}

		?>
		<div class="product_custom_field ">
			<div style="padding-left: 12px;"><h4><?php _e("Wine Club Connection Product Settings"); ?></h4><?php _e("If this product is a membership, select the associated membership level below. You can also choose to make this product available to members only."); ?></div>
			<div class='options_group' style='max-width:50%'><?php
			woocommerce_wp_select([
				'id'      => 'membershipLevelId',
				'name'    => 'membershipLevelId',
				'class'   => 'membershipLevelId',
				'label'   => __('Membership level:', 'woocommerce'),
				'value'   => get_post_meta( $post->ID, 'membershipLevelId', true ),
				'options' => $membershipLevels
			]);
			?></div> 
		</div>
		<div class="product_custom_field ">
			<div class='options_group'><?php 
			$value = get_post_meta( $post->ID, 'membership_check', true );
			?>
			<p class="form-field"><label for="membership_check"><?php _e("This is for members only:"); ?></label>	
				<input type="checkbox" name="membership_check" id="membership_check"  <?php if($value == 'on'){ ?> checked <?php } ?>><span class="description"><?php _e("Check this box to require a membership to purchase this product"); ?></span>
			</p>
			</div>
		</div>  
	<hr style="border-top-color:#eee;border-bottom:0px" />
	<?php
}

	/**
	 * Save the membership level data to product
     *
     * @since 1.0.0
	 */
	public function saveMembershipLevelData( $post_id ) 
	{


		if($_POST['membershipLevelId'] == 0) {
			delete_post_meta($post_id, 'membershipLevelId');
		} else {
			update_post_meta( $post_id, 'membershipLevelId', sanitize_text_field($_POST['membershipLevelId']));
		}
		if($_POST['membership_check'] == '') {
			delete_post_meta($post_id, 'membership_check');
		} else {
			update_post_meta( $post_id, 'membership_check', sanitize_text_field($_POST['membership_check']));
		}
	}

	

	/**
	 * Delete membership function
     *
	 * @since 1.0.0
	 */
	public function deleteMembership()
	{
		if(isset($_GET['deleteMembership'])) {
			global $wpdb;
			if(!empty($_GET['id'])){
				$membershipId = sanitize_text_field($_GET['id']);
				$wpdb->get_row($wpdb->prepare("DELETE FROM ".$wpdb->prefix."wineClubMembershipLevels WHERE id=%d", $membershipId));
			}

			header('Location: '.get_home_url().'/wp-admin/admin.php?page=wine-club-connection&tab=membershipLevels');
		}
	}


	/**
	*  Adding wine club connection membership to user profile
	*
	*  @since 1.0.0
	*/
	public function addWineClubMembershipToUserProfile( $user ) { 
		global $wpdb;
		$membershipLevels = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels");

		User::checkIfUserProcessManullyDateExpired($user->ID);
		?>
		<h3 class="wineClubHeading"><?php _e("Wine Club Connection User Settings", "blank"); ?></h3>
		<table class="form-table wineClubTable">
			<tr>
				<th><label for="wineClubMembershipLevel"><?php _e("Wine club connection membership level:"); ?></label></th>
				<td>
					<select name="wineClubMembershipLevel" id="wineClubMembershipLevel">
						<option value="0"><?php _e('No membership'); ?></option>
						<?php foreach($membershipLevels as $membershipLevel): ?>
							<option 
							value="<?php echo $membershipLevel->id ?>"
							<?php if(get_the_author_meta( 'wineClubMembershipLevel', $user->ID ) == $membershipLevel->id) {
								echo 'selected';
							}
							?>
							>
							<?php echo $membershipLevel->name ?>
						</option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="wineClubLocalPickup"><?php _e("Local pickup"); ?></label></th>
			<td>
				<fieldset>
					<label for="wineClubLocalPickup">
						<input name="wineClubLocalPickup" type="hidden" id="wineClubLocalPickup" value="0">
						<input name="wineClubLocalPickup" type="checkbox" id="wineClubLocalPickup" value="1" <?php if(get_the_author_meta( 'wineClubLocalPickup', $user->ID )): ?> checked="checked" <?php endif; ?>>
						<?php _e('Local pickup'); ?>
					</label><br>
				</fieldset>
			</td>
		</tr>
		<tr>
			<th><label for="wineClubProcesManully"><?php _e("Skip shipment"); ?></label></th>
			<td>
				<fieldset>
					<label for="wineClubProcesManully">
						<input name="wineClubProcesManully" type="hidden" id="wineClubProcesManully" value="0">
						<input name="wineClubProcesManully" type="checkbox" id="wineClubProcesManully" value="1" <?php if(get_the_author_meta( 'wineClubProcesManully', $user->ID )): ?> checked="checked" <?php endif; ?>>
						<?php _e('Skip shipment'); ?>
					</label><br>
				</fieldset>
			</td>
		</tr>
		<tr>
			<th><label for="wineClubProcesManullyTillDate"><?php _e("Skip shipment till date:"); ?> <small><?php _e('(Leave blank for process manually forever)'); ?></label></th>
				<td>
					<fieldset>
						<input min="<?php echo date('Y-m-d') ?>" name="wineClubProcesManullyTillDate" type="date" id="wineClubProcesManullyTillDate"  value="<?php echo get_the_author_meta( 'wineClubProcesManullyTillDate', $user->ID ) ?>">
						<br>
					</fieldset>
				</td>
			</tr>
			<tr class="user-wineClubProcesManullyNotes-wrap">
				<th><label for="wineClubProcesManullyNotes"><?php _e("Customer order notes:"); ?></label></th>
				<td>
					<textarea name="wineClubProcesManullyNotes" id="wineClubProcesManullyNotes" rows="5" cols="30"><?php echo get_the_author_meta( 'wineClubProcesManullyNotes', $user->ID ) ?></textarea>
				</td>
			</tr>
		</table>
	<?php }

    /**
     *  Update wineClubMembership in user profile meta
     *
     *  @since 1.0.0
     */
    public function updateWineClubMembershipToUserProfile( $user_id ) {

    	if (!current_user_can( 'edit_user', $user_id ) ) {
    		return;
    	}
    	if(isset($_POST['wineClubMembershipLevel'])) {
			
    		global $wpdb;
    		$membershipOld = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels WHERE id=%d", get_user_meta( $user_id, 'wineClubMembershipLevel', true)));
    		update_user_meta( $user_id, 'wineClubMembershipLevel', sanitize_text_field($_POST['wineClubMembershipLevel']) );
    		$membership = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels WHERE id=%d", sanitize_text_field($_POST['wineClubMembershipLevel'])));
    		do_action('wineClubMembershipUpdated', $user_id, $membershipOld->name, $membership->name);
    	}

    	if(isset($_POST['wineClubProcesManully'])) {
    		update_user_meta($user_id, 'wineClubProcesManully', sanitize_text_field($_POST['wineClubProcesManully']));
    	}

    	if(isset($_POST['wineClubLocalPickup'])) {
    		update_user_meta($user_id, 'wineClubLocalPickup', sanitize_text_field($_POST['wineClubLocalPickup']));
    	}

    	if(isset($_POST['wineClubProcesManullyTillDate'])) {
    		if(DateTime::createFromFormat('Y-m-d', $_POST['wineClubProcesManullyTillDate']) !== FALSE || $_POST['wineClubProcesManullyTillDate'] == '') {
    			update_user_meta($user_id, 'wineClubProcesManullyTillDate', sanitize_text_field($_POST['wineClubProcesManullyTillDate']));	        		
    		}
    	}

    	if(isset($_POST['wineClubProcesManullyNotes'])) {
    		update_user_meta($user_id, 'wineClubProcesManullyNotes', sanitize_text_field($_POST['wineClubProcesManullyNotes']));
    	}
    }

    /**
     *  Add Membersip Level To Contact Method /wp-admin/users.php
     *
     *  @since 1.0.0
     */
    function addMembershipLevelToContactMethod( $contactmethods ) {
    	$contactmethods['membershipLevel'] = 'Wine Club Connection Membership';
    	return $contactmethods;
    }

    /**
     *  Add membership level to user table /wp-admin/users.php
     *
     *  @since 1.0.0
     */
    public function addMembershipLevelToUserTable( $column ) {
    	$column['membershipLevel'] = 'Wine Club Connection Membership';
    	return $column;
    }

    /**
     *  Add membership level to user row /wp-admin/users.php
     *
     *  @since 1.0.0
     */
    public function membershipLevelUserRowInUserTable($val, $column_name, $user_id) {
    	switch ($column_name) {
    		case 'membershipLevel' :
    		$membershipLevelId = get_the_author_meta( 'wineClubMembershipLevel', $user_id );
    		global $wpdb;
    		$membership = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels WHERE id=%d", $membershipLevelId));
    		if($membership) {
    			return $membership->name;	            		
    		} else {
    			if($membershipLevelId != 0) {
    				return 'Deleted membership level';	            			
    			}
    		}
    		break;
    		default:
    	}
    	return $val;
    }

    /**
     *  Add membership level filter /wp-admin/users.php
     *
     *  @since 1.0.0
     */
    function addWineClubMembershipLevelFilter() {	
    	if(array_key_exists('wineClubMembershipLevel', $_GET) && $_GET[ 'wineClubMembershipLevel' ][ 0 ]) {
    		$membershipLevelId =  sanitize_text_field($_GET[ 'wineClubMembershipLevel' ][ 0 ]);
    	} else {
    		$membershipLevelId =  -1;
    	}
    	echo ' <select name="wineClubMembershipLevel[]" style="float:none;margin-left: 10px;"><option value="">Membership level</option>';

    	global $wpdb;
    	$membershipLevelsObj = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels");

    	foreach($membershipLevelsObj as $membershipLevel) {
    		$selected = $membershipLevel->id == $membershipLevelId ? ' selected="selected"' : '';
    		echo '<option value="' . $membershipLevel->id . '"' . $selected . '>' . $membershipLevel->name . '</option>';
    	}

    	echo '<input type="submit" class="button" value="Filter">';
    }

    /**
     *  Filter users by membership /wp-admin/users.php
     *
     *  @since 1.0.0
     */
    function filterUsersByWineClubMembershipLevel( $query ) {
    	global $pagenow;

    	if ( is_admin() && 'users.php' == $pagenow) {
    		if(array_key_exists('wineClubMembershipLevel', $_GET) && $_GET[ 'wineClubMembershipLevel' ][ 0 ]) {
    			$section =  sanitize_text_field($_GET[ 'wineClubMembershipLevel' ][ 0 ]);
    		} else {
    			$section =  null;
    		}
    		if ( null !== $section ) {
    			$meta_query = array(
    				array(
    					'key' => 'wineClubMembershipLevel',
    					'value' => $section
    				)
    			);
    			$query->set( 'meta_key', 'wineClubMembershipLevel' );
    			$query->set( 'meta_query', $meta_query );
    		}
    	}
    }
}