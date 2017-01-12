<?php

	$pw_woo_ad_search_grid_options_part=array(
		array(
			'id' => 'ad_search_grid_options_general_options',
			'title' => __('General Settings',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'icon' => '<i class="fa fa-clipboard"></i>',
			'variable' => 'ad_search_grid_general_options'
		),
		array(
			'id' => 'ad_search_grid_options_loading_popup_options',
			'title' => __('Loading Settings',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'icon' => '<i class="fa fa-clipboard"></i>',
			'variable' => 'ad_search_grid_loading_popup_options'
		),
		array(
			'id' => 'ad_search_grid_options_favorite_options',
			'title' => __('Favorite Settings',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'icon' => '<i class="fa fa-clipboard"></i>',
			'variable' => 'ad_search_grid_favorite_options'
		),
		array(
			'id' => 'ad_search_grid_options_search_options',
			'title' => __('Search Settings',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'icon' => '<i class="fa fa-clipboard"></i>',
			'variable' => 'ad_search_grid_search_options'
		),
		array(
			'id' => 'ad_search_grid_options_sendto_options',
			'title' => __('"Send to" Form',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'icon' => '<i class="fa fa-clipboard"></i>',
			'variable' => 'ad_search_grid_sendto_options'
		),
		array(
			'id' => 'ad_search_grid_options_translate_options',
			'title' => __('Translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'icon' => '<i class="fa fa-clipboard"></i>',
			'variable' => 'ad_search_grid_translate_options'
		),
	);
	
	//GENERAL OPTION PART
	$ad_search_grid_general_options= array(  
		array(  
			'label' => __('General option',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'general_option', 
			'type'  => 'notype'   
		),
		array(  
			'label' => '<strong>'.__('Price (From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set Price(From) for use in search form.Leave Blank to set Minimum price automatically',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'main_price_from',
			'type'  => 'numeric'
		),
		
		array(  
			'label' => '<strong>'.__('Price (To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set Price(To) for use in search form.Leave Blank to set Maximum price automatically',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'main_price_to',
			'type'  => 'numeric'
		),
		

		array(  
			'label' => '<strong>'.__('Price Step',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set Price set for Price Fields in Search Field. The Default Value is 50',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'price_step',
			'type'  => 'numeric'
		),
		
		array(  
			'label' => __('WooCommerce Page options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'page_option', 
			'type'  => 'notype'
		),
		
		array(  
			'label' => '<strong>'.__('Manage WooCommerce Pages',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('I want use from Magic Grid shortcode, Create page and replace WooCommerce default page with our page.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use',
			'type'  => 'checkbox'
		),
		
		array(  
			'label' => '<strong>'.__('Search Page',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('To configure the Search page functionality. Create a Search page using Magic Shortcode and choose its page here.This will use in widget shortcode(Search Form Target).',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_page',
			'type'  => 'pw_pages',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'	  => array('checkbox',true)
			),  
		),
		
		array(  
			'label' => '<strong>'.__('Shop Page',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('To configure the shop page functionality. Create a shop page using Magic Shortcode and choose its page here.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shop_page',
			'type'  => 'pw_pages',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'	  => array('checkbox',true)
			),  
		),
		
		array(  
			'label' => '<strong>'.__('Category Page',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('To configure the category page functionality. Create a category page using Magic Shortcode and choose its page here.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'category_page',
			'type'  => 'pw_pages',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'	  => array('checkbox',true)
			),  
		),
		
		array(  
			'label' => '<strong>'.__('Tag Page',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('To configure the tag page functionality. Create a tag page using Magic Shortcode and choose its page here.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tag_page',
			'type'  => 'pw_pages',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'	  => array('checkbox',true)
			),  
		),
		
		array(  
			'label' => '<strong>'.__('Taxonomy Page',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('To configure the taxonomy page functionality. Create a taxonomy page using Magic Shortcode and choose its page here.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'taxonomy_page',
			'type'  => 'pw_pages',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'magic_page_use'	  => array('checkbox',true)
			),  
		),
		
		
		
		
		/*array(  
			'label' => '<strong>'.__('Enable Ajax',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Enable/Disbale Ajax Mode in search',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_ajax',
			'type'  => 'radio',  
			'options' => array (  
				
				'one' => array (

					'label' => __('Yes',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'checked'  => 'CHECKED',  
					'value' => 'yes'  
				),
				'two' => array (

					'label' => __('No',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'checked'  => '',  
					'value' => 'no'  
				)
			)  
		),*/
		
		/*array(  
			'label' => '<strong>'.__('Default Archive Shortcode',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Default Archive SHortcode',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_default_archive_shortcode',
			'type'  => 'default_archive_grid'
		),*/
		
	);	
	
	$ad_search_grid_loading_popup_options= array(  
		/*array(  
			'label' => __('Loading option',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_option', 
			'type'  => 'notype'   
		),*/
		
		array(  
			'label' => '<strong>'.__('Loading Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Loading Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_type',
			'type'  => 'select',  
			'options' => array (  				
				'one' => array (
					'label' => __('Loading Pack',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'loading_pack'  
				),
				'two' => array (
					'label' => __('Upload Loading Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'upload'  
				)
			)  
		),
		
		array(  
			'label' => '<strong>'.__('Loading Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Loading Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_pack',
			'type'  => 'loading_type', 
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_type'	  => array('select','loading_pack')
			),  
		),
		array(  
			'label' => '<strong>'.__('Loading Color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose loading color',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_color',
			'type'  => 'colorpicker',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_type'	  => array('select','loading_pack')
			),  
		),
		array(  
			'label' => '<strong>'.__('Uplaod Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Upload Loading Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'upload_loading_icon',
			'type'  => 'upload' , 
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'loading_type'	  => array('select','upload')
			),
		)
		
	);	
	
	$ad_search_grid_favorite_options= array(  
		/*array(  
			'label' => __('Sticky Option',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sticky_option', 
			'type'  => 'notype'   
		),*/
		
		array(  
			'label' => '<strong>'.__('Enable Favorite Sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Yes, Please.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use',
			'type'  => 'checkbox'
		),
		
		array(  
			'label' => '<strong>'.__('Favorite Top Margin',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set top margin for favorite sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_margin',
			'type'  => 'numeric',
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use'	  => array('checkbox',true)
			),    
		),
		array(  
			'label' => '<strong>'.__('Favorite Position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose favorite stiky position',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_position',
			'type'  => 'select',  
			'options' => array (  
				
				'one' => array (

					'label' => __('Left',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'left'  
				),
				'two' => array (

					'label' => __('Right',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'right'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use'	  => array('checkbox',true)
			),    
		),
		
		array(  
			'label' => '<strong>'.__('Icon Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Icon Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_icon_type',
			'type'  => 'select',  
			'options' => array (  
				
				'one' => array (

					'label' => __('FontAwesome',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'fontawesome'  
				),
				'two' => array (

					'label' => __('Upload Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'upload'  
				)
			),
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use'	  => array('checkbox',true)
			),    
		),
		array(  
			'label' => '<strong>'.__('Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Icon for Favorite Sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_font_icon',
			'type'  => 'icon_type' , 
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_icon_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use'	  => array('checkbox',true),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_icon_type'	  => array('select','fontawesome')
			),
		),
		array(  
			'label' => '<strong>'.__('Uplaod Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Upload Icon for Favorite Sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_upload_icon',
			'type'  => 'upload' , 
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use',__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_icon_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_enable_favorite_use'	  => array('checkbox',true),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_favorite_icon_type'	  => array('select','upload')
			),
		),

	);	
	
	$ad_search_grid_search_options= array(  

		/*array(  
			'label' => __('Search option',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_option', 
			'type'  => 'notype'   
		),*/
	
		
		array(  
			'label' => '<strong>'.__('Search Top Margin',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set top margin for search sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_margin',
			'type'  => 'numeric'  
		),
		
		array(  
			'label' => '<strong>'.__('Search Height',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set height for search sticky content',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_height',
			'type'  => 'numeric'  
		),

		array(  
			'label' => '<strong>'.__('Icon Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Icon Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_icon_type',
			'type'  => 'select',  
			'options' => array (  
				
				'one' => array (

					'label' => __('FontAwesome',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'fontawesome'  
				),
				'two' => array (

					'label' => __('Upload Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),  
					'value' => 'upload'  
				)
			)  
		),
		array(  
			'label' => '<strong>'.__('Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Choose Icon for Search Sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_font_icon',
			'type'  => 'icon_type' , 
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_icon_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_icon_type'	  => array('select','fontawesome')
			),
		),
		array(  
			'label' => '<strong>'.__('Uplaod Icon',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Upload Icon for Favorite Sticky',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_upload_icon',
			'type'  => 'upload' , 
			'dependency' => array(
				'parent_id' => array(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_icon_type'),
				__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'option_search_icon_type'	  => array('select','upload')
			),
		),
	
	);	
	
	$ad_search_grid_sendto_options= array(  
		/*array(  
			'label' => __('"Send To" form Options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'Set Options for "Send to" Form', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_option', 
			'type'  => 'notype'   
		),*/
		
		array(  
			'label' => '<strong>'.__('Fields',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Select "Send To" form fields',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'sendto_form_fields',
			'type'  => 'pw_sendto_form_fields'  
		),
		array(  
			'label' => '<strong>'.__('Sender Email',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set Sender Email, Leave blank to Use Admin Email',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'sendto_form_receiver_email',
			'type'  => 'text'  
		),
		
	);	
	
	$ad_search_grid_translate_options = array(  
		/*array(  
			'label' => __('Translate Options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'desc'  =>'Set Options for Translate', 
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'translate_option', 
			'type'  => 'notype'   
		),*/

		array(  
			'label' => '<strong>'.__('Advanced Search',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_form_header_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('Share Product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'share_product_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('Quick View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'quick_view_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('Add to favorite',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'add_to_favorite_title',
			'type'  => 'text'  
		),

		array(  
			'label' => '<strong>'.__('"Send to" title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'sendto_form_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('"Show More" button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'sendto_show_more_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('"Add to cart" Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'add_to_cart_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('"Read More" Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'read_more_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('"Select options" Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'select_options_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('"View options" Button',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'view_options_title',
			'type'  => 'text'  
		),
		
		array(  
			'label' => '<strong>'.__('"Zoom Icon"',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</strong>',  
			'desc'  => __('Set your translate',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
			'id'    => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'zoom_title',
			'type'  => 'text'  
		),
	);	
	

	if (isset($_POST["update_settings"])) {
		// Do the saving
		foreach($pw_woo_ad_search_grid_options_part as $option_part){
			$this_part_variable=$$option_part['variable'];
			foreach ($this_part_variable as $field) { 
				if(!isset($_POST[$field['id']])){
					delete_option($field['id']);  
					continue;
				}
				
	
				$old = get_option($field['id']);  
				$new = $_POST[$field['id']];  
				if ($new && $new != $old) {  
					update_option($field['id'], $new);  
				} elseif ('' == $new && $old) {  
					delete_option($field['id']);  
				}
	
			} // end foreach  
		}
		?>
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><strong><?php echo __('Settings saved',__PW_WOO_AD_SEARCH_TEXTDOMAIN__);?>.</strong></p>
            </div>
		<?php
	}	
	
	echo '<div class="wrap">
			<h2>'.__('Magic Grid Settings',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</h2>
			<form method="POST" action="">
				<input type="hidden" name="update_settings" value="Y" />
				<div id="wizards" style="border:none">';
	
	foreach($pw_woo_ad_search_grid_options_part as $option_part){
		//TAB TITLE
		echo '<h2>'.$option_part['title'].'</h2>';
		
		echo '<section>
			<div id="'.$option_part['id'].'" style="height:34em;overflow-x: hidden;overflow-y: scroll;">';
			echo '<table class="form-table">'; 
			$this_part_variable=$$option_part['variable'];
			foreach ($this_part_variable as $field) {  
				if(isset($field['dependency']))  
				{
					echo pw_woo_ad_search_dependency($field['id'],$field['dependency']);	
				}
				// get value of this field if it exists for this post  
				$meta = get_option($field['id']);  
				// begin a table row with  
				$style='';
				if($field['type']=='notype')
					$style='style="border-bottom:solid 1px #ccc"';
				echo '<tr class="'.$field['id'].'_field" '.$style.'> 
		
					<th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
					<td>';  
					switch($field['type']) {  
		
						case 'notype':
							echo '<span class="description">'.$field['desc'].'</span>';
						break;
						
						case 'text':
							echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" class="'.$field['id'].'" value="'.$meta.'" />
							<br /><span class="description">'.$field['desc'].'</span>	';  
						break; 
						
						case 'radio':  
							foreach ( $field['options'] as $option ) {
								echo '<input type="radio" name="'.$field['id'].'" class="'.$field['id'].'" value="'.$option['value'].'" '.checked( $meta, $option['value'] ,0).' '.$option['checked'].' /> 
										<label for="'.$option['value'].'">'.$option['label'].'</label><br><br>';  
							}  
						break;
						
						case 'checkbox':  
								echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" '.checked( $meta, "on" ,0).'"/> 
									<br /><span class="description">'.$field['desc'].'</span>';  
							break;
						
						case 'select':  
							echo '<select name="'.$field['id'].'" id="'.$field['id'].'" class="'.$field['id'].'" style="width: 170px;">';  
							foreach ($field['options'] as $option) {  
								echo '<option '. selected( $meta , $option['value'],0 ).' value="'.$option['value'].'">'.$option['label'].'</option>';  
							}  
							echo '</select><br /><span class="description">'.__($field['desc'],__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>';  
						break;
						
						case 'numeric':  
							echo '
							<input type="number" name="'.$field['id'].'"  id="'.$field['id'].'" value="'.($meta=='' ? "":$meta).'" size="30" class="width_170 '.$field['id'].'" min="0" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Only Digits!" class="input-text qty text" />
		';
							echo '
								<br /><span class="description">'.$field['desc'].'</span>';  
						break;
						
						case "pw_pages":
						{
							$args = array(
								'depth'                 => 0,
								'child_of'              => 0,
								'selected'              => $meta,
								'echo'                  => 1,
								'name'                  => $field['id'],
								'id'                    => null, // string
								'show_option_none'      => __('Choose a Page',__PW_WOO_AD_SEARCH_TEXTDOMAIN__), // string
								'show_option_no_change' => null, // string
								'option_none_value'     => null, // string
							);
							$page=wp_dropdown_pages($args);
							echo '<br /><span class="description">'.$field['desc'].'</span>'; 
						}
						break;
						
						case "colorpicker":
							
							echo '<div class="medium-lbl-cnt">
											<label for="'.$field['id'].'" class="full-label">'.$field['label'].'</label>
											<input name="'.$field['id'].'" id="'.$field['id'].'" type="text" class="wp_ad_picker_color" value="'.$meta.'" data-default-color="#'.$meta.'">
										  </div>
									';	
							echo '
							
							<br />';
						break;
						
						case 'icon_type':  
							echo $meta;
							echo '<input type="hidden" id="'.$field['id'].'font_icon" name="'.$field['id'].'" value="'.$meta.'"/>';
							echo '<div class="'.$field['id'].' pw_iconpicker_grid" id="benefit_image_icon">';
							echo include(__PW_ROOT_WOO_AD_SEARCH__ .'/includes/font-awesome.php');
							echo '</div>';
							$output = '
							<script type="text/javascript"> 
								jQuery(document).ready(function(jQuery){';
									if ($meta == '') $meta ="fa-none";
									$output .= 'jQuery( ".'.$field['id'].' .'.$meta.'" ).siblings( ".active" ).removeClass( "active" );
									jQuery( ".'.$field['id'].' .'.$meta.'" ).addClass("active");';
							$output.='
									jQuery(".'.$field['id'].' i").click(function(){
										var val=(jQuery(this).attr("class").split(" ")[0]!="fa-none" ? jQuery(this).attr("class").split(" ")[0]:"");
										jQuery("#'.$field['id'].'font_icon").val(val);
										jQuery(this).siblings( ".active" ).removeClass( "active" );
										jQuery(this).addClass("active");
									});
								});
							</script>';
							echo $output;
						break; 	
						
						case 'upload':
							//wp_enqueue_media();
							$image = __PW_WOO_AD_SEARCH_URL__.'/assets/images/pw-transparent.gif';
							if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }
						
							echo '<input name="'.$field['id'].'" id="'.$field['id'].'" type="hidden" class="custom_upload_image '.$field['id'].'" value="'.(isset($meta) ? $meta:'').'" /> 
							<img src="'.(isset($image) ? $image:'').'" class="custom_preview_image" alt="" />
							<input name="btn" class="pw_woo_search_upload_image_button button" type="button" value="'.__('Choose Image',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" /> 
							<button type="button" class="pw_woo_ad_search_remove_image_button button">Remove image</button>';  
						break;
						
						case 'loading_type':
							echo '<input type="hidden" id="'.$field['id'].'_font_icon" name="'.$field['id'].'" value="'.$meta.'"/>';
							echo '<div class="'.$field['id'].' pw_iconpicker_grid pw_iconpicker_loading" id="benefit_image_icon">';
							include(__PW_ROOT_WOO_AD_SEARCH__ .'/includes/loading-icon.php');
							echo '</div>';
							$output = '
							<script type="text/javascript"> 
								jQuery(document).ready(function(jQuery){';
									if ($meta == '') $meta ="fa-none";
									$output .= 'jQuery( ".'.$meta.'" ).siblings( ".active" ).removeClass( "active" );
									jQuery( ".'.$meta.'" ).addClass("active");';
							$output.='
									jQuery(".'.$field['id'].' i").click(function(){
										var val=(jQuery(this).attr("class").split(" ")[0]!="fa-none" ? jQuery(this).attr("class").split(" ")[0]:"");
										jQuery("#'.$field['id'].'_font_icon").val(val);
										jQuery(this).siblings( ".active" ).removeClass( "active" );
										jQuery(this).addClass("active");
									});
								});
							</script>';
							echo $output;
						break;
						
						case "default_archive_grid":
						{
							global $pw_woo_ad_main_class,$wpdb;
			
							$query_meta_query=array('relation' => 'AND');
							$query_meta_query[] = array(
														'key' => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type',
														'value' => "search_archive_page",
														'compare' => '=',
													);
							
							$args=array('post_type' => 'ad_woo_search_grid',
										'post_status'=>'publish',
										'meta_query' => $query_meta_query,
									 );
							
							echo '<select name="'.$field['id'].'" id="'.$field['id'].'" class="'.$field['id'].'" style="width: 170px;">
									<option>'.__('Choose Shorcode',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</option>';  
							
							$my_query_archive = new WP_Query($args);
							if( $my_query_archive->have_posts()):
								while ( $my_query_archive->have_posts() ) : $my_query_archive->the_post(); 							
									echo '<option value="'.get_the_ID().'" '.selected($meta,get_the_ID(),0).'>'.get_the_title().'</option>';
								endwhile;	
							endif;	
							
							echo '</select>';
						}
						break;
						
						case "pw_sendto_form_fields":
						{
							echo '
							<label class="pw_showhide" for="displayProduct-price"><input name="'.$field['id'].'[name_from]" type="checkbox" '.(is_array($meta) && in_array("name_from",$meta) ? "CHECKED": "").' value="name_from" class="displayProduct-eneble">'.__('Name (From) Field',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
							
							<label class="pw_showhide" for="displayProduct-price"><input name="'.$field['id'].'[name_to]" type="checkbox" '.(is_array($meta) && in_array("name_to",$meta) ? "CHECKED": "").' value="name_to" class="displayProduct-eneble">'.__('Name (To) Field',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>                            
											
							<label class="pw_showhide" for="displayProduct-star"><input name="'.$field['id'].'[email]" type="checkbox" '.(is_array($meta) && in_array("email",$meta) ? "CHECKED": "").' value="email" class="displayProduct-eneble">'.__('Email (To) Field',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>                                    
														
							<label class="pw_showhide" for="displayProduct-metatag"><input name="'.$field['id'].'[description]" type="checkbox" '.(is_array($meta) && in_array("description",$meta) ? "CHECKED": "").' value="description">'.__('Description Field',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </label>
							';
						}
						break;
						
					}
			}
			echo '</table>';
		echo '</div></section>';	
	}
	
	echo '</div><!--END TAB-->';
	
	echo ' <p>
				<input type="submit" value="Save settings" class="button-primary"/>
			</p>
		</form>
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function(jQuery){
			
			jQuery("#pw_woo_ad_search_tabs").tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
		});
	</script>
	<script type="text/javascript">
		jQuery(document).ready(function(jQuery){
			
			jQuery("#wizards").steps({
				headerTag: "h2",
				bodyTag: "section",
				transitionEffect: "slideLeft",
				enableFinishButton: false,
				enablePagination: false,
				enableAllSteps: true,
				titleTemplate: "#title#",
				cssClass: "tabcontrol",
				onStepChanged :function (event, currentIndex, priorIndex) {
					if(currentIndex==1)
					{
						jQuery(".wp_ad_picker_color").wpColorPicker();
					}
				}
			});
		});
	</script>
	';
	
?>