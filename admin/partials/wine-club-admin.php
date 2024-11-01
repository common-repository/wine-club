<?php 

	$my_plugin_tabs = array(
	    'wine-club-connection' => 'Club Setup',
	    'wine-club-connection-shipping-settings' => 'Shipping Settings',
	    'wine-club-connection-bach-orders' => '<span style="color:#555">Batch Order Processing<b> (Pro!)</b></span>'
	);

?>

<div class="wrap" id="woo_club_main_div">
	
	<!-- Tab Menu -->
	<?php echo admin_tabs($my_plugin_tabs); ?>

	<?php 
		// GEt Membership level name
		global $wpdb;
		if(!empty($_GET['id'])){

			$membershipId = sanitize_text_field($_GET['id']);
			$membershipLevel = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels WHERE id=%d", $membershipId));
		}
		
		if(isset($_GET['tab'])){
			$check_query_tag = sanitize_text_field($_GET['tab']);
		
		
 		if($check_query_tag =='editMembershipLevel') {
	?>
		<h2 class="wp-heading"><a href="<?php echo admin_url(); ?>admin.php?page=wine-club-connection"><?php _e('Club Membership Levels'); ?></a> > <?php echo esc_attr($membershipLevel->name) ?> <span><?php _e('Edit membership levels'); ?></span></h2>
		
		<hr>
	<?php }else{  ?>
		<h2 class="wp-heading"><?php _e('Club Membership Levels'); ?><span><?php _e('Create or edit membership levels'); ?></span></h2>
		<hr>
	<?php } } ?>


 		

	<?php
		$tabs = array(
		    'membershipLevels' => 'Membership levels',
		    'addMembershipLevel' => 'Add membership',
		);

		//set current tab
		$tab = ( isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'membershipLevels' );
	?>

	<div class="wine-club-content">
		<?php if( $tab == 'membershipLevels' ): ?>
			<?php include plugin_dir_path( dirname( __FILE__ ) ) . 'partials/membership/membershipLevels.php'; ?>
		<?php elseif( $tab == 'addMembershipLevel' ): ?>
			<?php include plugin_dir_path( dirname( __FILE__ ) ) . 'partials/membership/addMembershipLevel.php'; ?>
		<?php elseif( $tab == 'editMembershipLevel' ): ?>
			<?php include plugin_dir_path( dirname( __FILE__ ) ) . 'partials/membership/editMembershipLevel.php'; ?>
		<?php endif; ?>
	</div>

</div>