<?php
class Wine_Club_Bach_Orders {
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

    public function addBachOrdersToMenu()
    {
        add_submenu_page($this->plugin_name, '<span style="color:#f18500">Batch Order Processing (Pro!)</span>', '<span style="color:#f18500">Batch Order Processing (Pro!)</span>', 'manage_woocommerce', $this->plugin_name.'-bach-orders', array($this, 'initSteps'));
    }

	public function initSteps() {
	    include_once( 'partials/bachOrders/initSteps.php' );
	}

}