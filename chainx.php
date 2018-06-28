<?php

/*
Plugin Name:  Chainx
Description:  Don't break the posting chain. Visualize your daily posting in calendar views. Motivate yourself to post daily.
Plugin URI:   https://www.indralukmana.com
Author:       Indra Lukmana
Version:      1.0
Text Domain:  chainx
Domain Path:  /languages
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
*/

// no direct access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// add top-level  menu
function chainx_add_toplevel_menu() {
	
	$chainx_calendar_page = add_menu_page(
								esc_html__('Chainx Calendar', 'chainx'),
								esc_html__('Chainx', 'chainx'),
								'publish_posts',
								'chainx',
								'chainx_display_calendar',
								'dashicons-admin-generic',
								null
							);
	
}
add_action( 'admin_menu', 'chainx_add_toplevel_menu' );

// display the plugin settings page
function chainx_display_calendar() {
	
	// check if user is allowed access
	if ( ! current_user_can( 'publish_posts' ) ) return;
	
	?>
	

	<div class="wrap">

	<div id="calendar"> </div>

	</div>
	
	<?php
	
}

