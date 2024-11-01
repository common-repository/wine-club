<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.domagojfranc.com
 * @since      1.0.0
 *
 * @package    Wine_Club_Connection
 * @subpackage Wine_Club_Connection/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wine_Club_Connection
 * @subpackage Wine_Club_Connection/includes
 * @author     Daedalushouse <andrea@daedalushouse.com>
 */
class Wine_Club_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		static::createMembershipLevel();
	}

	public static function createMembershipLevel() {
	   	global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$wineCluBMembershipTable = $wpdb->prefix . 'wineClubMembershipLevels';

		$sql = "CREATE TABLE $wineCluBMembershipTable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  name tinytext NOT NULL,
		  orderDiscount float NULL,
		  shippingMethod varchar(255),
		  shippingFlatRatePrice varchar(255) NULL,
		  description text NULL,
		  emailTitle text,
		  imageUrl text,
		  emailText text,
		  discountCategories text,
		  lastRun datetime NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


}
