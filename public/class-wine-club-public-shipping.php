<?php

class Wine_Club_Public_Shipping
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function getAvailableShippingMethods($rates, $package) {

        $userID = get_current_user_id();

    	if($userID == 0) {
    		$membershipLevelId = 0;
    	} else {
			$membershipLevelId = get_the_author_meta( 'wineClubMembershipLevel', $userID );
    	}


		if($membershipLevelId) {
			global $wpdb;
			$membershipLevel = MembershipLevels::find($membershipLevelId);

			if($membershipLevel) {
				$wineClubMembership = $membershipLevel->id;
			} else {
				$wineClubMembership = 'nonWineClubMember';
			}
		} else {
			$wineClubMembership = 'nonWineClubMember';
		}


		$availableRates = [];

        foreach ( array_reverse($rates) as $rate ) {
			$rate_id = $rate->id;

			if ( isset( $rate->instance_id ) ) {
                if(strpos($rate->id, 'wf_shipping_ups') !== false) {
                    $rate_id = $rate->id;
                } else {
                    $rate_id = $rate->method_id . ':' . $rate->instance_id;
                }
			}

			if ( $this->checkIfUserHasRate( $wineClubMembership, $rate_id ) ) {
				$availableRates[ $rate_id ] = $rate;
			}
		}

		return $availableRates;
    }

    public function checkIfUserHasRate( $wineClubMembership, $rate_id ) {
        $return = false;
		$shippingOptions = get_option( 'wineClubShippingRoles' );
		$rate_id_temp = (string) $rate_id;

        if (strpos($rate_id, 'wf_shipping_ups') !== false) {
            $rate_id_temp = 'wf_shipping_ups';
        }


		if ( ( isset( $shippingOptions[ $wineClubMembership ][ $rate_id_temp ] ) && 'on' == $shippingOptions[ $wineClubMembership ][ $rate_id_temp ] ) || ! $shippingOptions ) {
            $return = true;
		} elseif ( 'nonWineClubMember' == $wineClubMembership && isset( $shippingOptions['nonWineClubMember'][ $rate_id_temp ] ) && 'on' == $shippingOptions['nonWineClubMember'][ $rate_id_temp ] ) {
            $return = true;
		}

		return $return;
	}

}
