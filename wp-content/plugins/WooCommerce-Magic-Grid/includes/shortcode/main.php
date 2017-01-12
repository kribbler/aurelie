<?php
add_action('wp_ajax_pw_woo_ad_search_fetch_shortcode', 'pw_woo_ad_search_fetch_shortcode');
add_action('wp_ajax_nopriv_pw_woo_ad_search_fetch_shortcode', 'pw_woo_ad_search_fetch_shortcode');
function pw_woo_ad_search_fetch_shortcode() {
	
	$query_meta_query=array('relation' => 'AND');
	$query_meta_query[] = array(
				'key' => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type',
				'value' => "search_grid_widget",
				'compare' => '!=',
			);
	
	$args=array('post_type' => 'ad_woo_search_grid',
	'post_status'=>'publish',
	'meta_query' => $query_meta_query,
	);
	
	$args=array(
		'post_type'=>'ad_woo_search_grid',
		'posts_per_page'=>-1,
		'order'=>'data',
		'orderby'=>'DESC',
		
	);
	$loop = new WP_Query( $args );		

		while ( $loop->have_posts() ) : 
			$loop->the_post();
			echo '<option value="'.get_the_ID().'">
					'.get_the_title().'
				</option>';
		endwhile;	

	wp_die();
}



add_action('admin_head','pw_woo_ad_search_shortcodes_addbuttons');	
function pw_woo_ad_search_shortcodes_addbuttons() {
	global $typenow;
	// check user permissions
	if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
	return;
	}
	// check if WYSIWYG is enabled
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "pw_woo_ad_search_shortcodes_tinymce_plugin");
		add_filter('mce_buttons', 'register_pw_woo_ad_search_shortcodes_button');
	}
}
function pw_woo_ad_search_shortcodes_tinymce_plugin($plugin_array) {
	$plugin_array['flash_sale_shortcodes_button'] = plugin_dir_url_pw_woo_ad_search.'includes/shortcode/includes/tinymce_button.js';
	return $plugin_array;
}
function register_pw_woo_ad_search_shortcodes_button($buttons) {
   array_push($buttons, "flash_sale_shortcodes_button");
   return $buttons;
}

//Shortcode Ui
add_filter('init','pw_woo_ad_search_shortcodes_add_scripts');
function pw_woo_ad_search_shortcodes_add_scripts() {
	if(!is_admin()) {
		wp_enqueue_style('flash_sale_shortcodes', plugin_dir_url_pw_woo_ad_search.'includes/shortcode/includes/shortcodes.css');
		wp_enqueue_script('jquery');
		wp_register_script('flash_sale_shortcodes_js', plugin_dir_url_pw_woo_ad_search.'includes/shortcode/includes/shortcodes.js', 'jquery');
		wp_enqueue_script('flash_sale_shortcodes_js');
	} else {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}		
}



?>