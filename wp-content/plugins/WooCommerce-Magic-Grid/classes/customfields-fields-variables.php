<?php
	
	//GENERAL OPTION PART
	$ad_search_grid_general_setting = array(  
		array(  
			'label' => '<strong>'.__('Shortcode Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Shortcode Mode.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type',
			'type'  => 'select',  
			'options' => array (  
				
				'one' => array (

					'label' => __('Advanced Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'grid'  
				),
				'two' => array (

					'label' => __('Advanced Search',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'search'  
				),
				'three' => array (

					'label' => __('Advanced Search With Build Query',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'search_build_query'  
				)/*,
				'five' => array (

					'label' => __('Advanced Search in Arche Page',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'search_archive_page'  
				)*/,
				'six' => array (

					'label' => __('Advanced Search in Widget',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'search_grid_widget'  
				)
			)  
		),
		
		/*array(  
			'label' => '<strong>'.__('Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Icon for Search Header',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tab_icon',
			'type'  => 'icon_type'  
		),
*/
	);	
	
	//BUILD QUERY PART
	$ad_search_grid_build_query = array(
		array(  
			'label' => '<strong>'.__('Custom Post Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Custom Post Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_type',
			'type'  => 'hidden'
		),
		array(  
			'label' => '<strong>'.__('Build Query Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Build Query Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'fetch_type',
			'type'  => 'chosen_select',  
			'options' => array (  
				
				'one' => array (

					'label' => __('All Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'all_product'  
				),
				'two' => array (

					'label' => __('Custom Query',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'build_query'  
				),
				'three' => array (

					'label' => __('On-sale Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'on_sale_product'  
				),
				'four' => array (

					'label' => __('In Stock Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'in_stock_product'  
				),
				'five' => array (

					'label' => __('Out of Stock Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'out_stock_product'  
				),
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query') 	
			), 
		),  
		array(  
			'label' => '<strong>'.__('Build Query',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Select/Unselect Taxonomy, Category or other tag for build Query',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'build_query_taxonomy',
			'type'  => 'pw_custom_taxonomy',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'fetch_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'fetch_type'	  => array('select','build_query') 	
			),
			//all.js js_composer line 182
		),

		array(  
			'label' => '<strong>'.__('Order by',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Order by',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'build_query_order_by',
			'type'  => 'order_by_multiselect',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query') 	
			), 
		),
		
		array(  
			'label' => '<strong>'.__('Order Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Order Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'build_query_order_type',
			'type'  => 'select',
			'options' => array (  
				'one' => array (
					'label' => __('Descending',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'DESC'  
				),
				'two' => array (

					'label' => __('Ascending',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'ASC'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query') 	
			), 
		),
		
		array(  
			'label' => '<strong>'.__('Hide Recent Product(s)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'hide_recent_post',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query') 	
			), 
		),
		array(  
			'label' => '<strong>'.__('Number of Recnet Product(s)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Enter Number of Product(s) hide in fetch',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'hide_recent_post_num',
			'type'  => 'numeric',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'hide_recent_post'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query') ,
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'hide_recent_post'	  => array('checkbox',true) 	
			),
		),
		array(  
			'label' => '<strong>'.__('Just Featured product(s)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'featured_product',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query') 	
			),   
		),
		array(  
			'label' => '<strong>'.__('Hide Free product(s)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'hide_free_product',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query') 	
			),   
		),
		array(  
			'label' => '<strong>'.__('Show Hidden Product(s)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_hidden_product',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type'	  => array('select','grid','search_build_query') 	
			),   
		),
	);
	
	//SEARCH_ORDER FIELDS PART
	$ad_search_grid_fields_order_setting = array(  
		
		array(  
			'label' => '<strong>'.__('Show Filter/Search Fields',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter',
			'type'  => 'checkbox'  
		),
		array(  
			'label' => '<strong>'.__('Select Filter/Search Fields',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Fileds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields',
			'type'  => 'pw_custom_search_fields',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'	  => array('checkbox',true) 	
			),
		),
		
		array(  
			'label' => '<strong>'.__('Fileds/Orders Style',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Style for Category/Taxonomy/Orders in search form.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields_tax_style',
			'type'  => 'select',
			'options' => array (  
				'one' => array (
					'label' => __('Display as Dropdown',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'dropdown_style'  
				),
				'two' => array (
					'label' => __('Display as List',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'list_style'  
				),
				'three' => array (
					'label' => __('Display as Filter',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'filter_style'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'	  => array('checkbox',true) 	
			),
		),
		array(  
			'label' => '<strong>'.__('Preset Style',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Preset Style.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields_tax_style_preset',
			'type'  => 'select',
			'options' => array (  
				'one' => array (
					'label' => __('Preset 1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset_1'  
				),
				'two' => array (
					'label' => __('Preset 2',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset_2'  
				),
				'three' => array (
					'label' => __('Preset 3',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset_3'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields_tax_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields_tax_style'=> array('select','dropdown_style','filter_style'),	
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'	  => array('checkbox',true) 	
			),
		),	
				
		array(  
			'label' => '<strong>'.__('Select Category/Taxonomy',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Txonomy for Filter/Search',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_taxonomy',
			'type'  => 'pw_custom_taxonomy_filter',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'	  => array('checkbox',true) 	
			),
		),
		
		array(  
			'label' => '<strong>'.__('Enable Reset Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_reset_btn',
			'type'  => 'checkbox',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter'	  => array('checkbox',true) 	
			),
		),
		
		array(  
			'label' => '<strong>'.__('Show Order Options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_order',
			'type'  => 'checkbox'  
		),
		array(  
			'label' => '<strong>'.__('Order Fields',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Order Fields',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_orders',
			'type'  => 'pw_custom_search_orders',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_order'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_order'	  => array('checkbox',true) 	
			),
		),
		
		array(  
			'label' => '<strong>'.__('Order Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Order Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_order_type',
			'type'  => 'select',
			'options' => array (  
				'one' => array (
					'label' => __('Descending',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'DESC'  
				),
				'two' => array (

					'label' => __('Ascending',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'ASC'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_order'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_order'	  => array('checkbox',true) 	
			),
		),

	);
	
	//ADVANCED OPTION PART
	$ad_search_grid_advence_setting = array(  
		array(  
			'label' => '<strong>'.__('Search Position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Search Position.Note : For Widget type You can not choose "Top of the page" and For another type you can not use "In sied bar"',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('Top of the Page',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'search_top'  
				),
				'two' => array (

					'label' => __('Left Sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'search_left_sticky'  
				),
				'three' => array (

					'label' => __('Right Sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'search_right_sticky'  
				),
				'four' => array (

					'label' => __('Popup',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'serach_popup'  
				),
				'five' => array (

					'label' => __('In Side Bar',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'search_sidebar'  
				)
			)
		),
		array(  
			'label' => '<strong>'.__('Disable Toggle',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_enable_toggle',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'	  => array('select','search_top'),
			),   
		),
		array(  
			'label' => '<strong>'.__('Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Icon for Sticky Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_icon',
			'type'  => 'icon_type',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'	  => array('select','search_left_sticky','search_right_sticky','serach_popup')	
			),  
		),
		
		array(  
			'label' => '<strong>'.__('Sticky Margin Top',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Enter Number of margin top',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_margin',
			'type'  => 'numeric',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'	  => array('select','search_left_sticky','search_right_sticky')	
			), 
		),
		array(  
			'label' => '<strong>'.__('Sticky Height',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Enter number of height',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_height',
			'type'  => 'numeric',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'	  => array('select','search_left_sticky','search_right_sticky')	
			), 
		),
		
		array(  
			'label' => '<strong>'.__('Pagination Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Pagination Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('No Pagination',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'no_pagination'  
				),
				'two' => array (

					'label' => __('Horizontal Page Number',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'pagination_pagenumber_hor'  
				),
				'three' => array (

					'label' => __('Vertical Page Number',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'pagination_pagenumber_ver'  
				),
				'four' => array (

					'label' => __('"Show More" Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'pagination_showmore'  
				),
				'five' => array (

					'label' => __('Infinite Scroll',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'pagination_infinite'  
				)
			)
		),
		array(  
			'label' => '<strong>'.__('Pagination Position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose pagination position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_hor_pagenumber_position',
			'type'  => 'select',  
			'options' => array (  
				
				'one' => array (

					'label' => __('After the Items',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'bottom' 
				),
				'two' => array (

					'label' => __('Before the Items',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'top'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'	  => array('select','pagination_pagenumber_hor')
			),  
		),
		
		array(  
			'label' => '<strong>'.__('Horizontal Preset',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Horizontal Page type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_hor_pagenumber_type',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Preset 1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset1'  
				),
				'two' => array (

					'label' => __('Preset 2',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset2' 
				),
				'three' => array (

					'label' => __('Preset 3',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset3' 
				),
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'	  => array('select','pagination_pagenumber_hor')
			),  
		),
		array(  
			'label' => '<strong>'.__('Pagination Position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose pagination position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_ver_pagenumber_position',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Left of Items',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'left'  
				),
				'two' => array (

					'label' => __('Right of Items',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'right' 
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'	  => array('select','pagination_pagenumber_ver')
			),  
		),
		
		array(  
			'label' => '<strong>'.__('Vertical Preset',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Vertical Page type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_ver_pagenumber_type',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Preset 1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset1'  
				),
				'two' => array (

					'label' => __('Preset 2',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset2' 
				),
				'three' => array (

					'label' => __('Preset 3',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset3' 
				),
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'	  => array('select','pagination_pagenumber_ver')
			),  
		),
		array(  
			'label' => '<strong>'.__('Pagination Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set pagination color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_number_color_set',
			'type'  => 'pw_pagination_number_color_set',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'	  => array('select','pagination_pagenumber_hor','pagination_pagenumber_ver')
			),  
		),
		array(  
			'label' => '<strong>'.__('Show More type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose show more type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_show_more_type',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Preset 1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset1'  
				),
				'two' => array (

					'label' => __('Preset 2',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset2' 
				),
				'three' => array (

					'label' => __('Preset 3',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'preset3' 
				),
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'	  => array('select','pagination_showmore')
			),  
		),
		array(  
			'label' => '<strong>'.__('Show more color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set "Show More" button color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_show_more_color_set',
			'type'  => 'pw_pagination_showmore_color_set',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'	  => array('select','pagination_showmore')
			),  
		),
		
		array(  
			'label' => '<strong>'.__('Search Bar Title Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose title color for your search bar',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_title_color',
			'value'  => '#727272',
			'type'  => 'color_picker'
		),
		array(  
			'label' => '<strong>'.__('Search Bar Value Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose value color for your search bar',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_value_color',
			'value'  => '#3d3d3d',
			'type'  => 'color_picker'
		),
		array(  
			'label' => '<strong>'.__('Search Bar Fontsize',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set fontsize for yoursearch bar',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_fontsize',
			'value'  => '10',
			'type'  => 'numeric'  
		),
		
		array(  
			'label' => '<strong>'.__('Maximum Items',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Enter Maximum Items that you want fetch. Enter -1 or leave blank for fetch all records.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_per_page',
			'value'  => '-1',
			'type'  => 'text',  
		),

		array(  
			'label' => '<strong>'.__('Desktop Columns',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Desktop Columns',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_column_desktop',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('1 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-md-12'  
				),
				'two' => array (

					'label' => __('2 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-md-6'  
				),
				'three' => array (

					'label' => __('3 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-md-4'  
				),
				'four' => array (

					'label' => __('4 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-md-3'  
				),
				'five' => array (

					'label' => __('6 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-md-2'  
				)
				
			)
		),
		array(  
			'label' => '<strong>'.__('Tablet Columns',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Tablet Columns',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_column_tablet',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('1 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-sm-12'  
				),
				'two' => array (

					'label' => __('2 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-sm-6'  
				),
				'three' => array (

					'label' => __('3 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-sm-4'  
				),
				'four' => array (

					'label' => __('4 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-sm-3'  
				),
				'five' => array (

					'label' => __('6 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-sm-2'  
				)
			)
		),
		array(  
			'label' => '<strong>'.__('Mobile Columns',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Mobile Columns',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_column_mobile',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('1 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-xs-12'  
				),
				'two' => array (

					'label' => __('2 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-xs-6'  
				),
				'three' => array (

					'label' => __('3 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-xs-4'  
				),
				'four' => array (

					'label' => __('4 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-xs-3'  
				),
				'five' => array (

					'label' => __('6 Column',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-col-xs-2'  
				)
			)
		),
	);
	
	//FRONT-END PART
	$ad_search_grid_layout_setting = array(  
		
		array(  
			'label' => '<strong>'.__('Preset Fron-End Layout',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Preser Grids.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'preset_frontend',
			'type'  => 'preset_frontend',
		),
		
		array(  
			'label' => '<strong>'.__('Front-end Style',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Front-end Style',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',
			'type'  => 'select',  
			'options' => array (  
				/*'one' => array (
					'label' => __('Default Theme (Use for Woocommerce)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'default_theme'  
				),*/
				'two' => array (

					'label' => __('Style One (General Grid)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'style_1'  
				),
				'three' => array (

					'label' => __('Style Two (List)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'style_2'  
				),
				'four' => array (

					'label' => __('Style Three (Color)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'style_3'  
				),
				'five' => array (

					'label' => __('Style Four (Table)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'style_4'  
				)
			)
		),
		
		array(  
			'label' => '<strong>'.__('List Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose list type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'list_type',
			'type'  => 'select',  
			'options' => array (  
				'two' => array (

					'label' => __('Style One',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-list-layout1-cnt'  
				),
				'three' => array (

					'label' => __('Style Two',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-list-layout2-cnt'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_2'),
			),   
		),
		
		array(  
			'label' => '<strong>'.__('Colored Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose colored type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'colored_type',
			'type'  => 'select',  
			'options' => array (  
				'two' => array (

					'label' => __('Style One',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-colored-layout1-cnt'  
				),
				'three' => array (

					'label' => __('Style Two',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-colored-layout2-cnt'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_3'),
			),   
		),
		
		array(  
			'label' => '<strong>'.__('Show Switching icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_switch_icon',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
			),   
		),
		
		array(  
			'label' => '<strong>'.__('Display Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Display Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('Fit Row/Column Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'fit_row_grid'  
				),
				'two' => array (
					'label' => __('Different Size Grid',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'masonry_grid'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1')	
			), 
		),
		array(  
			'label' => '<strong>'.__('Different Size Pattern',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Different Size Pattern',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'diff_size_pattern',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('Pattern 1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'pattern-1'  
				),
				'two' => array (

					'label' => __('Pattern 2',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'pattern-2'  
				),
				'three' => array (

					'label' => __('Pattern 3',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'pattern-3'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display' => array('select','masonry_grid'),	
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1')	
			),
		),
	
		/*array(  
			'label' => '<strong>'.__('Larger Size Based On',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Larger Size Based on : ',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'size_based',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('popularity',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'popularity'  
				),
				'two' => array (

					'label' => __('Star (rate)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'rate'  
				),
				'three' => array (

					'label' => __('Sale Item',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'sale_item'  
				),
				'four' => array (

					'label' => __('Best Seller',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'best_seller'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display' => array('select','masonry_grid'),	
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1')	
			),
		),*/
		
		/*array(  
			'label' => '<strong>'.__('Image Position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Image Position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_position',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'left'  
				),
				'two' => array (

					'label' => __('Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'right'  
				),
				'three' => array (

					'label' => __('Random',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'random'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_2')	
			), 
		),*/
		array(  
			'label' => '<strong>'.__('Grid Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Grid Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('Boxed (Hover Overlay)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'over_item'  
				),
				'two' => array (

					'label' => __('Outer Description',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'outer_item'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1')	
			), 
		),
		
		array(  
			'label' => '<strong>'.__('Equal Height',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please. Set this option for Fit Row Grid.<br /><strong>Note : </strong> If you use this option may slow down your page load speed.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'equal_height',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'	      => array('select','outer_item')	
			),   
		),
		
		array(  
			'label' => '<strong>'.__("Enable Masonry Mode",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Yes, Please",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_masonry',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1')	,
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'		  => array('select','outer_item')
			), 
		),
		array(  
			'label' => '<strong>'.__('Box Effect',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Boxed Effect Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_box_effect_type',
			'type'  => 'select',  
			'options' => array (  
				'two' => array (

					'label' => __('Effect 1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect1'  
				),
				'three' => array (

					'label' => __('Effect 2',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect2'  
				),
				'four' => array (

					'label' => __('Effect 3',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect3'  
				),
				'five' => array (

					'label' => __('Effect 4',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect4'  
				),
				'six' => array (

					'label' => __('Effect 5',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect5'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'	  => array('select','over_item'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1')	
			), 
		),
		
		array(  
			'label' => '<strong>'.__('Desctiption Position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Description Position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type_outer',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('Bottom',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'bottom'  
				),
				'two' => array (

					'label' => __('Top',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'top'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'	  => array('select','outer_item'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1')
			), 
		),
		
		array(  
			'label' => '<strong>'.__("Color set",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Color",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'color_set',
			'type'  => 'pw_custom_color_set',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_3')	
			), 
		),
		
		array(  
			'label' => '<strong>'.__('Image Effect',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Image Effect Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('No Effect',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'no_effect'  
				),
				/*'two' => array (

					'label' => __('Image Sliding',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'image_sliding'  
				),*/
				'three' => array (

					'label' => __('Second Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'second_image'  
				),
				'four' => array (

					'label' => __('Zoom In',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-zoomin'  
				),
				'five' => array (

					'label' => __('Zoom Out',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-zoomout'  
				),
				'six' => array (

					'label' => __('Gray Scale',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-grayscale'  
				),
				'seven' => array (

					'label' => __('Rotate Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-rotateright'  
				),
				'eight' => array (

					'label' => __('Rotate Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-rotateleft'  
				),
				'nine' => array (

					'label' => __('Blur',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-blur'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_2','style_3')	
			), 
		),
		array(  
			'label' => '<strong>'.__('Outer Overlay Effect',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Overlay Effect Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_outer_overlay_type',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('No Effect',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'no_effect'  
				),
				'two' => array (

					'label' => __('Effect 1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect1'  
				),
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_2')	,
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'		  => array('select','outer_item')
			), 
		),
		/*array(  
			'label' => '<strong>'.__('Icon Effect',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Outer Icon Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_outer_icon_type',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (
					'label' => __('No Effect',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'no_effect'  
				),
				'two' => array (

					'label' => __('Effect 1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect1'  
				),
				'three' => array (

					'label' => __('Effect 2',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect2'  
				),
				'four' => array (

					'label' => __('Effect 3',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'effect3'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type'	  => array('select','outer_item'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1')	
			), 
		),*/
		array(  
			'label' => '<strong>'.__("Enable Box Shadow",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Yes, Please",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_2','style_3','style_4')	
			), 
		),
		array(  
			'label' => '<strong>'.__("Box Shadow",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Box Shadow type",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_shadow_set',
			'type'  => 'pw_custom_box_shadow_set',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_2','style_3','style_4'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow'	  => array('checkbox','on'),	
			), 
		),
		array(  
			'label' => '<strong>'.__("Item Background",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Item Background",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'background_set',
			'type'  => 'pw_custom_box_background_set',  
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_2'),
			), 
		),
		
		array(  
			'label' => '<strong>'.__("Overlay Background",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Overlay background",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'overlay_background_set',
			'type'  => 'pw_custom_box_background_overlay_set',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_2')
			),  
		),

		
		array(  
			'label' => __('Button options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  => __('Use This Optins for Genral Grid (Grid type : Outer Description), List, Table',__PW_WOO_AD_SEARCH_TEXTDOMAIN__), 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'button_option', 
			'type'  => 'notype' ,
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_2','style_4')	
			), 
		),
		array(  
			'label' => '<strong>'.__("Button Options",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Button Options",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'set_btn_option',
			'type'  => 'pw_custom_btn_set',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_2','style_4')	
			), 
		),
		
		array(  
			'label' => '<strong>'.__('Quick View Style',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Quick View Style',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'quickview_style',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Disable',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => ''  
				),
				'two' => array (

					'label' => __('Popup',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'popoup'  
				)/*,
				'three' => array (

					'label' => __('Top of the Item',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'top'   
				)*/
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3')	
			), 
		),
		
		array(  
			'label' => __('Table Background color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  => __('Choose Table Background color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tbl_background_color',
			'value'  => '#d6d6d6', 
			'type'  => 'color_picker' ,
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_4')	
			),
		),
		array(  
			'label' => __('Table Head Background color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  => __('Choose Table Head Background color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tbl_head_background_color', 
			'type'  => 'color_picker' ,
			'value'  => '#f4f4f4',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_4')	
			),
		),
		array(  
			'label' => __('Table Head Text color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  => __('Choose Table Head Text color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tbl_head_text_color', 
			'type'  => 'color_picker' ,
			'value'  => '#595959',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_4')	
			),
		),
		array(  
			'label' => __('Table Row hover color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  => __('Choose Table Row hover color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tbl_hover_row_color', 
			'type'  => 'color_picker' ,
			'value'  => '#f4f4f4',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_4')	
			),
		),
		/*array(  
			'label' => __('Product name color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  => __('Choose Product name color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tbl_product_name_color', 
			'type'  => 'color_picker' ,
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_4')	
			),
		),*/
		array(  
			'label' => __('Table Border color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  => __('Choose Table Border color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tbl_border_color', 
			'type'  => 'color_picker' ,
			'value'  => '#d6d6d6',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_4')	
			),
		),
		
		array(  
			'label' => __('General options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'general_option', 
			'type'  => 'notype'   
		),
		array(  
			'label' => '<strong>'.__("Show/Hide item's fields",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Show/Hide item's fields",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'item_fields',
			'type'  => 'pw_custom_search_fields',
		),
		
		array(  
			'label' => __('Carousel options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'carousel_option', 
			'type'  => 'notype',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid')	
			),    
		),
		array(  
			'label' => '<strong>'.__("Display Items as Carousel",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Display items in Horizontal Carousel",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid')	
			),   
		),
		array(  
			'label' => '<strong>'.__("Desktop Item(s)",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enter number of items for Desktop Mode.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_desk_cols',
			'type'  => 'numeric',
			'value'  => '1',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			), 
		),
		array(  
			'label' => '<strong>'.__("Tablet Item(s)",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enter number of items for Tablet Mode.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_tablet_cols',
			'type'  => 'numeric',
			'value'  => '1',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			), 
		),
		array(  
			'label' => '<strong>'.__("Mobile Item(s)",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enter number of items for Mobile Mode.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_mobile_cols',
			'type'  => 'numeric',
			'value'  => '1',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			),
		),
		
		array(  
			'label' => '<strong>'.__("Item Margin",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enter margin of Carousel Items.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_item_margin',
			'type'  => 'numeric',
			'value'  => '0',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			),
		),
		array(  
			'label' => '<strong>'.__("Slide Speed",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Choose Carousel Slide Speed.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_item_slide_speed',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('0.1 Second',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '100'  
				),
				'two' => array (

					'label' => __('0.2 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '200'  
				),
				'three' => array (

					'label' => __('0.3 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '300'  
				),
				'four' => array (

					'label' => __('0.4 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '400'   
				),
				'five' => array (

					'label' => __('0.5 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '500'   
				),
				'sex' => array (

					'label' => __('0.6 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '600'   
				),
				'seven' => array (

					'label' => __('0.7 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '700'   
				),
				'eight' => array (

					'label' => __('0.8 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '800'   
				),
				'nine' => array (

					'label' => __('0.9 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '900'   
				),
				'ten' => array (

					'label' => __('1 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '1000'   
				)
				
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			),
		),
		array(  
			'label' => '<strong>'.__("Pagination Speed",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Choose Carousel Pagination Speed.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_item_speed',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('1 Second',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '1000'  
				),
				'two' => array (

					'label' => __('2 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '2000'  
				),
				'three' => array (

					'label' => __('3 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '3000'  
				),
				'four' => array (

					'label' => __('4 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '4000'   
				),
				'five' => array (

					'label' => __('5 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '5000'   
				),
				'sex' => array (

					'label' => __('6 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '6000'   
				),
				'seven' => array (

					'label' => __('7 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '7000'   
				),
				'eight' => array (

					'label' => __('8 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '8000'   
				),
				'nine' => array (

					'label' => __('9 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '9000'   
				),
				'ten' => array (

					'label' => __('10 Seconds',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => '10000'   
				)
				
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			),
		),
		
		array(  
			'label' => '<strong>'.__("Autoplay",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enable Carousel Autoplay.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_autoplay',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			),
		),
		
		array(  
			'label' => '<strong>'.__("Show Controls",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enable Carousel Controls.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			),
		),
		
		array(  
			'label' => '<strong>'.__("Controls Color",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Controls Color",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_ctrl_color',
			'type'  => 'pw_custom_4_color',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls'  => array('checkbox','on'),			
			),
		),
		array(  
			'label' => '<strong>'.__("Controls Radius",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Border Radius for Controls.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_ctrl_radius',
			'type'  => 'pw_custom_border_radius_set',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls'  => array('checkbox','on'),			
			),
		),
		array(  
			'label' => '<strong>'.__("Controls Position",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Choose Position of Carousel Controls.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_ctrl_position',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Top - Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-top-left-ctrl'  
				),
				'two' => array (

					'label' => __('Top - Center',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-top-center-ctrl'  
				),
				'three' => array (

					'label' => __('Top - Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-top-right-ctrl'  
				),
				'four' => array (

					'label' => __('Center - Side',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-top-middle-ctrl'   
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls'  => array('checkbox','on'),			
			),
		),
		
		
		array(  
			'label' => '<strong>'.__("Show Pagination",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enable Carousel Pagination.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on')		
			),
		),
		
		array(  
			'label' => '<strong>'.__("Pagination Color",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Color for Carousel Pagination.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_paginatio_color',
			'type'  => 'pw_custom_box_background_set',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination'  => array('checkbox','on'),			
			),
		),
		array(  
			'label' => '<strong>'.__("Pagination Radius",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Border Radius for Pagination.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination_radius',
			'type'  => 'pw_custom_border_radius_set',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination'  => array('checkbox','on'),			
			),
		),
		array(  
			'label' => '<strong>'.__("Pagination Position",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Choose Position of Carousel Pagination .",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination_position',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'left'  
				),
				'two' => array (

					'label' => __('Center',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'center'  
				),
				'three' => array (

					'label' => __('Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'right'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'	  => array('select','style_1','style_3'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'	  => array('select','fit_row_grid'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'	  => array('checkbox','on'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination'  => array('checkbox','on'),			
			),
		),
		
		
		array(  
			'label' => '<strong>'.__('Icon Style',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Icon Style',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'icon_style',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Round',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-roundicon'  
				),
				'two' => array (

					'label' => __('Squar',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-squaricon'  
				),
				'three' => array (

					'label' => __('Radiused',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-radiusedicon'   
				),
				'four' => array (

					'label' => __('No Border',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'woo-nobordericon'   
				)
			),
		),
		
		array(  
			'label' => '<strong>'.__('Show "Read More" Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_read_more',
			'type'  => 'checkbox'  
		),
		
		array(  
			'label' => '<strong>'.__('Show "Zoom" Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_zoom',
			'type'  => 'checkbox'  
		),
		
		array(  
			'label' => '<strong>'.__('Show "Add to Favorite" Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite',
			'type'  => 'checkbox'  
		),
		
		array(  
			'label' => __('Favorite Icon color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  => __('Choose Favorite Icon color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'favorite_icon_color', 
			'type'  => 'pw_favorite_color_set' ,
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_favorite'	  => array('checkbox','on')	
			),
		),
		
		
		array(  
			'label' => '<strong>'.__('Show Share Icons',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_share_icons',
			'type'  => 'checkbox'  
		),
		array(  
			'label' => '<strong>'.__('Share Icons',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Select Share Icons',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_icons',
			'type'  => 'checkbox',  
			'options' => array (  
				'one' => array (
					'label' => __('Facebook',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'facebook'  
				),
				'two' => array (

					'label' => __('Goolge Plus',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'google_plus'  
				),
				'three' => array (

					'label' => __('Twitter',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'twitter'  
				),
				'four' => array (

					'label' => __('Pinterest',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'pinterest'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_share_icons'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_share_icons'	  => array('checkbox','on')	
			), 
		),
		
		array(  
			'label' => '<strong>'.__('Show Send To',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_send_to',
			'type'  => 'checkbox'  
		),
		array(  
			'label' => '<strong>'.__('Thumbnail Size',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Thumbnail Size',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'thumbnail_size',
			'type'  => 'select',  
			'options' => array (  
				'one' => array (

					'label' => __('Original Size',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'orginal_size'  
				),
				'two' => array (

					'label' => __('Single Product Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'shop_single' 
				),
				'three' => array (

					'label' => __('Catalog Images',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'shop_catalog' 
				)
			),
		),
		array(  
			'label' => '<strong>'.__("Image Ratio",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Choose Image Ratio.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_ratio',
			'type'  => 'select',  
			'options' => array (  
				
				'one' => array (

					'label' => __('1:1 Squar',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'thumb-1-1'  
				),
				'two' => array (

					'label' => __('1:1 Round',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'thumb-1-1 woo-roundimg'  
				),
				'three' => array (

					'label' => __('1:2',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'thumb-1-2'  
				),
				'four' => array (

					'label' => __('2:1',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'thumb-2-1'  
				)
			),
		),
		
		
		/*array(  
			'label' => '<strong>'.__("Custom Size",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) .",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'thumbnail_size_custom',
			'type'  => 'text'
			,
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'thumbnail_size'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'thumbnail_size'	  => array('select','custom_size')	
			), 
		),*/
		
		
		array(  
			'label' => '<strong>'.__("Excerp Length",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Enter number of word(s) .",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_len',
			'type'  => 'numeric',
		),
		
		array(  
			'label' => '<strong>'.__("Border",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Border",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'border_set',
			'type'  => 'pw_custom_border_set'
		),
		
		array(  
			'label' => '<strong>'.__("Active Border Radius",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Yes, Please",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius',
			'type'  => 'checkbox'
		),
		
		array(  
			'label' => '<strong>'.__("Border Radius",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Border Radius",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'border_radius_set',
			'type'  => 'pw_custom_border_radius_set',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'	  => array('checkbox','on')	
			), 
		),
		
		array(  
			'label' => '<strong>'.__("Padding",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Padding",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'padding_set',
			'type'  => 'pw_custom_padding_set'
		),
		
		array(  
			'label' => '<strong>'.__("Margin",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Margin",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'margin_set',
			'type'  => 'pw_custom_margin_set'
		),

		/*array(  
			'label' => '<strong>'.__("Overlay",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Overlay",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'overlay_set',
			'type'  => 'pw_custom_overlay_set'
		),*/
		
		
		array(
			'label' => __('Font Options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'font_option', 
			'type'  => 'notype'   
		),
		array(  
			'label' => '<strong>'.__("General Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Item Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'font_set',
			'type'  => 'pw_custom_general_font_set'
		),
		
		array(  
			'label' => '<strong>'.__("Price Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Price Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'price_font_set',
			'type'  => 'pw_custom_general_font_set'
		),
		
		array(  
			'label' => '<strong>'.__("Title Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Title Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'title_font_set',
			'type'  => 'pw_custom_font_set'
		),
		
		array(  
			'label' => '<strong>'.__("Excerpt Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Excerpt Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_font_set',
			'type'  => 'pw_custom_general_font_set'
		),
		
		array(  
			'label' => '<strong>'.__("Meta Data Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Meta Data Font",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'meta_font_set',
			'type'  => 'pw_custom_font_set'
		),
		
		array(  
			'label' => '<strong>'.__("Sale Banner",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Sale Banner Options",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'banner_sale_font_set',
			'type'  => 'pw_custom_banner_font_set'
		),
		
		array(  
			'label' => '<strong>'.__("Featured Banner",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Set Featured Banner Options",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'banner_featured_font_set',
			'type'  => 'pw_custom_banner_font_set'
		),
		
		array(  
			'label' => __('Popup option',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup_option', 
			'type'  => 'notype'   
		),
		array(  
			'label' => '<strong>'.__('Popup Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Popup Background color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'popup_bg_color',
			'value'  => '#ffffff',
			'type'  => 'color_picker'
		),
		array(  
			'label' => '<strong>'.__('Popup Overlay Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Popup Overlay color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'popup_overlay_color',
			'value'  => '#333333',
			'type'  => 'color_picker'
		),
		array(  
			'label' => __('Tooltip option',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tooltip_option', 
			'type'  => 'notype'   
		),
		array(  
			'label' => '<strong>'.__('Tooltip Background Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Tooltip Background color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color',
			'value'  => '#333333',
			'type'  => 'color_picker'
		),
		array(  
			'label' => '<strong>'.__('Tooltip Text Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Tooltip Text color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_text_color',
			'value'  => '#ffffff',
			'type'  => 'color_picker'
		),
		array(  
			'label' => __('Save as Prest option',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'save_option', 
			'type'  => 'notype'   
		),
		array(  
			'label' => '<strong>'.__("Save as Preset",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Yes, Please.I want save this layout as preset.",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset',
			'type'  => 'checkbox'
		),
		array(  
			'label' => '<strong>'.__('Uplaod Screenshot',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Upload Icon for Prest preview',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_prest_image',
			'type'  => 'upload' , 
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset'	  => array('checkbox',true),
			),
		),
		/*array(  
			'label' => '<strong>'.__("Replace if Exist?",__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __("Yes, Please. If you want seve new preset, Uncheck this!",__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'replace_preset',
			'type'  => 'checkbox',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset'	  => array('checkbox',true),
			),
		),*/
	);
	
?>