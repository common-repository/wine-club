<?php
	global $wpdb;

	$membershipLevels = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels");
?>
<table class="widefat">
	<?php if(count($membershipLevels)): ?>
		<?php 
			$i = 0;
			foreach($membershipLevels as $membershipLevel) : 
		?>
		<tr <?php if($i % 2 == 0) echo ' class="alternate"' ?>>
			<td class="row-title"><?php echo $membershipLevel->name ?></td>
			<td>
				<a class="button-secondary" href="?page=wine-club-connection&tab=editMembershipLevel&id=<?php echo $membershipLevel->id ?>"><?php esc_attr_e( 'Edit level' ); ?></a>
				<a class="button-secondary button-delete" href="admin.php?deleteMembership=true&id=<?php echo $membershipLevel->id ?>"><?php esc_attr_e( 'Delete level' ); ?></a>
			</td>
		</tr>
		<?php $i++; ?>
		<?php endforeach; ?>
	<?php else: ?>
		<h2><?php _e('There is currently no memberships setup. Create your first wine club connection membership level'); ?> <a href="?page=wine-club-connection&tab=addMembershipLevel"><?php _e('here.'); ?></a></h2>
	<?php endif; ?>
</table>
<br>
<a class="button-primary" href="?page=wine-club-connection&tab=addMembershipLevel"><?php esc_attr_e( 'Add new membership level' ); ?></a>

<script>
jQuery(function() {
    jQuery('.button-delete').click(function() {
        return window.confirm("Are you sure?");
    });
});
</script>