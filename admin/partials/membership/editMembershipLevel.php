<?php
	global $wpdb;
	
	if($_POST) {
		$retrieved_nonce = sanitize_text_field($_REQUEST['_wpnonce']);
		if (!wp_verify_nonce($retrieved_nonce, 'edit_wineclub_membership' ) ) die( 'Failed security check' );

		$membership = sanitize_text_field($_POST['membershipName']);
		$orderDiscount = sanitize_text_field($_POST['membershipOrderDiscount']);
		$shippingMethod = sanitize_text_field($_POST['membershipShippingMethod']);
        $shippingFlatRatePrice = sanitize_text_field($_POST['shippingFlatRatePrice']);
		$description = sanitize_textarea_field($_POST['membershipDescription']);
        $emailTitle = sanitize_text_field($_POST['emailTitle']);
        $emailMessage = sanitize_textarea_field($_POST['emailText']);
		
		
		// Upload file
		if($_FILES['imageUrl']['name'] != ''){
			
			$uploadedfile = $_FILES['imageUrl'];
		
			$upload_overrides = array( 'test_form' => false );
			
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			$imageurl = "";
			if ( $movefile && ! isset( $movefile['error'] ) ) {
				$imageurl = $movefile['url'];
			} else {
			   echo $movefile['error'];
			}
		}else{
			
			$get_image_url = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels WHERE id=%d", sanitize_text_field($_GET['id'])));
				
			$imageurl =	$get_image_url->imageUrl;
		}

		if(array_key_exists('wineClubDiscountCategories', $_POST)) {
			$discountCategories =  serialize($_POST['wineClubDiscountCategories']);
		} else {
			$discountCategories =  serialize([]);
		}

		if($shippingFlatRatePrice == '') {
			$shippingFlatRatePrice = 0;
		}
		
		if($membership == '') {
			echo '<div class="notice notice-error is-dismissible"><p>Membership name is required.</p></div>';
		} elseif(!is_numeric($shippingFlatRatePrice)) {
			echo '<div class="notice notice-error is-dismissible"><p>Shipping flate rate price has to be numeric.</p></div>';
		} elseif($emailTitle == '') {
            echo '<div class="notice notice-error is-dismissible"><p>Email title is required.</p></div>';
        } elseif($emailMessage == '') {
            echo '<div class="notice notice-error is-dismissible"><p>Email message is required.</p></div>';
        } else {
            $OldmembershipLevel = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels WHERE id=%d", sanitize_text_field($_GET['id'])));
            $wpdb->update(
				$wpdb->prefix . 'wineClubMembershipLevels',
				[
					'name' => $membership,
					'orderDiscount' => $orderDiscount,
					'shippingMethod' => $shippingMethod,
					'shippingFlatRatePrice' => $shippingFlatRatePrice,
					'discountCategories' => $discountCategories,
					'description' => $description,
                    'emailTitle' => $emailTitle,
					'imageUrl' => $imageurl,
                    'emailText' => $emailMessage,
				],
				['id' => sanitize_text_field($_GET['id'])]
			);

            do_action('wineClubNameUpdated', sanitize_text_field($_GET['id']), $OldmembershipLevel->name, $membership);

            echo '<div class="notice notice-success is-dismissible"><p>Membership successfully updated.</p></div>';
		}
	}
	$membershipLevel = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."wineClubMembershipLevels WHERE id=%d", sanitize_text_field($_GET['id'])));
?>
<h2 class="sub-heading"><?php _e('Edit membership'); ?></h2>

<form method="post" enctype="multipart/form-data">
	<input name="action" type="hidden" value="createMembership" />
	<?php wp_nonce_field( 'edit_wineclub_membership') ?>

	<fieldset>
        <label for="name"><?php _e('Membership name:'); ?></label>
        <input type="text" class="regular-text" name="membershipName" value="<?php echo esc_attr($membershipLevel->name) ?>" />
    </fieldset>
	<fieldset>
        <label for="name"><?php _e('Order Discount:'); ?></label>
        <select name="membershipOrderDiscount" class="regular-text">
        	<?php for ($i = 0; $i <= 100; $i++) { ?>
        		<option 
    			  value="<?php echo $i ?>"
    			  <?php if($i == esc_attr(@$membershipLevel->orderDiscount)) {
    			  	echo 'selected';
			  	  } ?>
			  	>
    			  <?php if($i == 100): ?> 
			  		<?php _e('Free order'); ?>
		  		  <?php elseif($i == 0): ?>
		  		  	<?php _e('No discount'); ?>
    			  <?php else: ?>
        				<?php echo $i ?> %
    			  <?php endif; ?>
				</option>
        	<?php } ?>
        </select>
    </fieldset>
    <fieldset class="section-discount">
        <h3 class="sub-heading"><?php _e('Discount included in categories'); ?></h3>
		<?php
			  $args = array(
			         'taxonomy'     => 'product_cat',
			         'orderby'      => 'name',
			         'show_count'   => 0,
			         'pad_counts'   => 0,
			         'hierarchical' => 1,
			         'title_li'     => '',
			         'hide_empty'   => 0
			  );
			 $all_categories = get_categories( $args );
			 foreach ($all_categories as $cat) {
			        $category_id = $cat->term_id;
			        $checkedCategories = unserialize($membershipLevel->discountCategories);
			        if(is_array($checkedCategories) && in_array($category_id, $checkedCategories)) {
		        		echo '<label class="wine-field"><input type="checkbox" name="wineClubDiscountCategories[]" value="'. $category_id .'" checked>'. $cat->name;
		        	} else {
			        	echo '</label><input type="checkbox" name="wineClubDiscountCategories[]" value="'. $category_id .'">'. $cat->name;			        	
			        }    
			       
			}
		?>
    </fieldset>
    <fieldset>
        <label for="name"><?php _e('Club Designated shipping method:'); ?></label>
        <select id="membershipShippingMethod" name="membershipShippingMethod" class="regular-text">
        	<?php $array = WC()->shipping->get_shipping_methods();
            foreach($array as $a)
            {
                if($a->enabled == "yes")
                {?>
                  <option value="<?php echo($a->id); ?>" <?php if($a->id == esc_attr(@$membershipLevel->shippingMethod)) {
                    echo 'selected';
                } ?> ><?php echo($a->method_title); ?></option>  
              <?php  
                    
                }
            }
            ?>
        </select>
    </fieldset>
    <fieldset class="<?php if(@$membershipLevel->shippingMethod != 'flat_rate') echo 'hideField' ?>" id="shippingFlatRatePrice">
        <label for="shippingFlatRatePrice"><?php _e('Flate rate price '); ?><small><?php _e('(Without currency)'); ?></small> :</label>
        <input type="text" class="regular-text" name="shippingFlatRatePrice"  value="<?php echo esc_attr($membershipLevel->shippingFlatRatePrice) ?>" />
    </fieldset>
    <fieldset>
		<label for="membershipDescription"><?php _e('Wine club connection description:'); ?></label>
		<textarea name="membershipDescription" id="membershipDescription" rows="10" cols="100"><?php echo esc_textarea($membershipLevel->description) ?></textarea>
    </fieldset>
    <hr class="wine-line">

    <h2 class="sub-heading"><?php _e('Welcome email settings'); ?></h2>
    <fieldset>
        <label for="name"><?php _e('Email title:'); ?></label>
        <input required type="text" class="regular-text" name="emailTitle" value="<?php echo esc_attr($membershipLevel->emailTitle) ?>" />
    </fieldset>
	<fieldset>
        <label for="imageUrl"><?php _e('Email Logo:'); ?></label>
        <input type="file" name="imageUrl" id="imageUrl" class="imageUrl" value="<?php echo esc_attr($membershipLevel->imageUrl) ?>"><br>
		<img width="150" src="<?php echo esc_url($membershipLevel->imageUrl) ?>">
    </fieldset>
    <fieldset>
        <label for="membershipDescription"><?php _e('Email message:'); ?></label>
        <textarea required name="emailText" id="emailText" rows="10" cols="100"><?php echo esc_textarea($membershipLevel->emailText) ?></textarea>
    </fieldset>
	<div class="action_left">
		<?php submit_button('Save settings'); ?>
	</div>
</form>
