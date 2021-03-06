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

	add_action( 'load-' . $chainx_calendar_page, 'load_calendar_libs');
	
}
add_action( 'admin_menu', 'chainx_add_toplevel_menu' );

function load_calendar_libs(){
	add_action('admin_enqueue_scripts', 'enqueue_calendar_libs');
}

function enqueue_calendar_libs(){

	wp_enqueue_style('jquery', plugin_dir_url( dirname( __FILE__ ) ) . 'chainx/fullcalendar/fullcalendar.min.css');
	
	wp_enqueue_script('jquery', plugin_dir_url( dirname( __FILE__ ) ) . 'chainx/fullcalendar/jquery.min.js', array(), null);
	wp_enqueue_script('jquery-ui', plugin_dir_url( dirname( __FILE__ ) ) . 'chainx/fullcalendar/jquery-ui.min.js', array(), null);
	wp_enqueue_script('moment', plugin_dir_url( dirname( __FILE__ ) ) . 'chainx/fullcalendar/moment.min.js', array(), null);
	wp_enqueue_script('fullcalendar', plugin_dir_url( dirname( __FILE__ ) ) . 'chainx/fullcalendar/fullcalendar.min.js', array('jquery', 'moment'), null);
	
	wp_enqueue_script('chainx', plugin_dir_url( dirname( __FILE__ ) ) . 'chainx/chainx.js', array('jquery', 'fullcalendar'), null);

	wp_localize_script('chainx', 'chainx_vars', array( 'events' => chainx_post_dates_to_array() ));
}

function chainx_post_dates_to_array(){

	$post_and_dates = array();

	$query = new WP_Query(array('post_status' => 'publish'));

	if ($query->have_posts()) {
		while($query->have_posts()) :
			$query->the_post();
			$temp_array = array(
						'title' => get_the_title(),
						'start' => get_the_date('Y-m-d', get_the_ID())
			);

			array_push($post_and_dates, $temp_array);
		endwhile;
	}

	return $post_and_dates;

}

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


