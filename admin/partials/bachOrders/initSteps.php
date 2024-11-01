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
	
	<h2 class="wp-heading"><?php _e('Pro add ons'); ?></h2>
	<hr>
	<div class="pro-add-on-features">
		<ul>
			<li><?php _e('Batch & Automated Billing'); ?></li>
			<li><?php _e('Square POS 2-way'); ?></li>
		</ul>
	</div>
	<h2><a target="_blank" href="https://wpclubconnect.com/wcs-features/"><?php _e('For These Features Purchase Our PRO Version'); ?></a></h2>
</div>

