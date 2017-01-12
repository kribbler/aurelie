<?php
	if ( ! function_exists( 'register_woo_ad_search' ) ) 
	{
		add_action('init', 'register_woo_ad_search');
		function register_woo_ad_search() {
			$args = array(
				'description' => __('Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
				'show_ui' => true,
				//'menu_position' => 25,
				'exclude_from_search' => true,
				'menu_icon' => 'dashicons-schedule',
				'labels' => array(
					'name'=> __('Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'singular_name' => __('Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'add_new' => __('Add Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'add_new_item' => __('Add Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'edit' => __('Edit Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'edit_item' => __('Edit Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'new-item' => 'New Magic Grid',
					'view' => __('View Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'view_item' => __('View Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'search_items' => __('Search Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'not_found' => __('No Magic Grid Found',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'not_found_in_trash' => __('No Magic Grid Found in Trash',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
					'parent' => __('Parent Magic Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)
				),
				'public' => true,
				//'taxonomies' => array('propertytype'),
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => true,
				'supports' => array('title'),
				'has_archive' => true,
				
			);
		
			register_post_type( 'ad_woo_search_grid' , $args );
		}
	}
	
	
	if ( ! function_exists( 'custom_add_property_columns_woo_search' ) ) 
	{
		add_filter('manage_ad_woo_search_grid_posts_columns', 'custom_add_property_columns_woo_search');
		function custom_add_property_columns_woo_search($columns) {
			//unset($columns['title']);	
			unset($columns['date']);	
			//$columns['custom_tracking_no']= 'Tracking Number' ;
			$columns['shortcode_result']= __('Shortcode',__PW_WOO_AD_SEARCH_TEXTDOMAIN__);
			return $columns;
		}
	}
	

	if ( ! function_exists( 'custom_render_post_columns_woo_search' ) ) 
	{
		add_action('manage_posts_custom_column', 'custom_render_post_columns_woo_search', 10, 2);
		function custom_render_post_columns_woo_search($column_name, $id) {
	
			switch ($column_name) {
				
				case 'shortcode_result':
					echo '[pw-woo-ad-search-grid id="'.$id.'"]';
				break;	
		
			}
		}
	}
?>