<?php 

$my_plugin_tabs = array(
    'wine-club-connection' => 'Club Setup',
    'wine-club-connection-shipping-settings' => 'Shipping Settings',
    'wine-club-connection-bach-orders' => '<span style="color:#555">Batch Order Processing<b> (Pro!)</b></span>'
);

?>

<div class='wrap' id="woo_club_main_div">


    <?php echo admin_tabs($my_plugin_tabs); ?>

    <form method='post' action='' id='psroles_settings'>
        <div class='shippingrolepanel'>
            <table class='wc_shipping' cellspacing='0'>
                <thead>
                    <tr class="wc-tb-heading">
                        <th>&nbsp;</th>
                        <?php foreach ($shipping_zones as $zone) : ?>
                            <?php if (sizeof($zone['shipping_methods']) > 0) : ?>
                               <th colspan="<?php echo sizeof($zone['shipping_methods']); ?>" class="zone-heading">
                                 <strong><?php echo esc_attr($zone['zone_name']); ?></strong>
                                </th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                    <!-- Zone title row -->
                    <tr class="heading-name">
                        <th>&nbsp;</th>
                        <?php foreach ($shipping_zones as $zone) : ?>
                            <?php foreach($zone['shipping_methods'] as $col):?>
                                <th class="zone-title">
                                    <?php echo $this->get_shipping_method_title($col); ?>
                                </th>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($wineClubs as $wineClub): ?>
                        <?php $this->print_shipping_row($wineClub, $shipping_zones, $methodarray); ?>
                    <?php endforeach; ?>

                    <?php $this->print_shipping_row('Non wine club connection members', $shipping_zones, $methodarray);?>
                </tbody>
            </table>
        </div>

        <div style='clear:both;'></div>
        <div class="action_left">
			<p class='submit'>
				<input type='submit' name='Submit' class='button-primary' value='<?php _e('Save Changes', 'woocommerce-role-based-methods'); ?>' />
				<input type='hidden' name='settings-updated' value='true'/>
			</p>
		</div>
    </form>
</div>
