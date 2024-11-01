<?php
    global $wpdb;
    $user = wp_get_current_user();

	if($_POST) {
		$retrieved_nonce = sanitize_text_field($_REQUEST['_wpnonce']);
		if (!wp_verify_nonce($retrieved_nonce, 'cancelMembership_nonce' ) ) die( 'Failed security check' );
        $oldMembershipLevel = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix."wineClubMembershipLevels WHERE id=%d", get_the_author_meta( 'wineClubMembershipLevel', $user->ID )));
        update_user_meta($user->ID, 'wineClubMembershipLevel', '');
        do_action('wineClubMembershipUpdated', $oldMembershipLevel->name, $user->ID, '');
    }

	$membershipLevel = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix."wineClubMembershipLevels WHERE id=%d", get_the_author_meta( 'wineClubMembershipLevel', $user->ID )));
?>

<?php if($membershipLevel) :?>
	<h2><?php _e('Your membership level is:'); ?> <?php echo esc_attr($membershipLevel->name) ?></h2>
	<p><?php echo esc_textarea($membershipLevel->description) ?></p>

	<script>
		 jQuery(document).ready(function(){
		 	jQuery('#membershipLevelCancelForm').submit(function(event){
			     if(!confirm("Are you sure that you want to cancel your membership?")){
			        event.preventDefault();
			      }
			    });
		   });
	</script>
<?php else: ?>
	<h2><?php _e('Wine Club Connection Membership'); ?></h2>
	<p><?php _e('You can join our wine club connection or change your membership level below.'); ?></p>
<?php endif; ?>

<?php if($membershipLevel) :?>
	<h3 style="margin-top:30px"><?php _e('Switch membership level'); ?></h3>
<?php else: ?>
	<h3 style="margin-top:30px"><?php _e('Join Wine Club Connection!'); ?></h3>
<?php endif; ?>

<?php 
	$qureyMembershipArgs =[
		'post_type' => 'product',
		'meta_query' => [
			[
				'key' => 'membershipLevelId',
				'value' => '0',
				'compare' => '>',
			]
		]
	];

	$membershipLeveles = new WP_Query( $qureyMembershipArgs );
?>
	<ul class="joinWineClubList">
<?php
	if( $membershipLeveles->have_posts()) : while( $membershipLeveles->have_posts() ) : $membershipLeveles->the_post(); 
?>
		<?php wc_get_template_part( 'content', 'product' ); ?>
<?php
	endwhile;
    endif;
    wp_reset_query();
 ?>

</ul>

<?php if($membershipLevel) :?>
	<br><br><br>
	<hr>
	 <form action="#" method="POST" id="membershipLevelCancelForm">
		<input type="hidden" value="cancelMembership">
		<?php wp_nonce_field( 'cancelMembership_nonce') ?>
		<input type="submit" class="woocommerce-Button button" value="Cancel membership">
	</form>
<?php endif; ?>
