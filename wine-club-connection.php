<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpclubconnect.com
 * @since             1.0.0
 * @package           Wine_Club_Connection
 *
 * @wordpress-plugin
 * Plugin Name:       Wine Club Connection
 * Plugin URI:        https://wpclubconnect.com/wcs-features/
 * Description:       An easy to set up Woocommerce plugin to give your store recurring club functionality. Ideal for Wine Club Connection, subscription boxes, or any business based on recurring product memberships.
 * Version:           1.1.3
 * Author:            Godardcreative
 * Author URI:        https://wpclubconnect.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wine-club-connection
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	return;
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wine-club-activator.php
 */
function activate_wine_club() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wine-club-activator.php';
	Wine_Club_Activator::activate();
} 
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wine-club-deactivator.php
 */
function deactivate_wine_club() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wine-club-deactivator.php';
	Wine_Club_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wine_club' );
register_deactivation_hook( __FILE__, 'deactivate_wine_club' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wine-club.php';

function addMembershipAsProductType() {
	class WC_Product_Membership_Level extends WC_Product_Simple  {
		public function __construct( $product ) {
			$this->product_type = 'membership_level';
			parent::__construct( $product );
		}
	}
}
add_action( 'plugins_loaded', 'addMembershipAsProductType' );

/* Replace add to cart button with login */
add_action('woocommerce_before_shop_loop_item','remove_loop_add_to_cart_button'); 
function remove_loop_add_to_cart_button(){
    global $product;
    if($product->get_meta('membership_check') == 'on')
    {
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); 
    }
    else
    {
        add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); 
    }
}

/*STEP 2 -ADD NEW BUTTON THAT LINKS TO PRODUCT PAGE FOR EACH PRODUCT
*/

add_action('woocommerce_after_shop_loop_item','replace_add_to_cart_with_login'); 
function replace_add_to_cart_with_login() {
    global $product;
    if($product->get_meta('membership_check') == 'on')
    {
        $link = get_permalink(get_page_by_path('my-account')); //change 'my-account' to your login page slug.
        echo '<a href="' . esc_url($link) . '" class="button product_type_simple add_to_cart_button product_type_simple" data-default_icon="sf-icon-account" style="border:none;background-color: #fff;" data-toggle="tooltip" data-original-title="Login"><i class="sf-icon-account"></i><span>Login</span></a>';
    }
}

add_action( 'woocommerce_single_product_summary', 'login_button_on_product_page', 30 );

function login_button_on_product_page() {
    global $product;
    if($product->get_meta('membership_check') == 'on')
    {
        $link = get_permalink(get_page_by_path('my-account')); //change 'my-account' to your login page slug.
        echo '<button type="button" data-default_text="Login" data-default_icon="sf-icon-account" class="product_type_simple button alt" onclick="window.location=\'' . esc_attr($link) . '\'"><i class="sf-icon-account"></i><span>Login</span></button>';
    }
}

// define the woocommerce_before_main_content callback 
function action_woocommerce_before_main_content( ) { 
    $product = wc_get_product();
    if($product->get_meta('membership_check') == 'on')
    {
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    }
}; 
         
// add the action 
add_action( 'woocommerce_before_main_content', 'action_woocommerce_before_main_content', 10, 2 );


// Create WP Admin Tabs on-the-fly.
function admin_tabs($tabs, $current=NULL){
	
	if(is_null($current)){
		if(isset($_GET['page'])){
			$current = sanitize_text_field($_GET['page']);
		}
	}
	$content = '';
	$content .='<div id="woo-club-header-logo"><img src="'.plugin_dir_url( __FILE__ ).'admin/images/wineclubconnection.png"></div>';
	$content .= '<h2 class="nav-tab-wrapper">';
	foreach($tabs as $location => $tabname){
		
		if($current == $location){
			$class = ' nav-tab-active';
		} else{
			$class = '';    
		}
		$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
	}
	$content .= '</h2>';
	return $content;

}
	

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wine_club() {

	$plugin = new Wine_Club();
	$plugin->run();

}
run_wine_club();
