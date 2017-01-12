<?php
	global $pw_woo_ad_main_class;
	
	//CHEK ALL ON_OFF VARIABLE (DEFAULT VALUE)
	$pw_sf_post_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_type'];

	$pw_sf_shortcode_id=$id;

	$pw_sf_part='pw_woo_ad_grid';
	
	
	$pw_sf_display_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'];
	$pw_sf_grid_type='grid';
	
	$pw_sf_orders=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_orders','custom_field','');
	$pw_sf_order_type=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_order_type','custom_field','');
	
	$pw_sf_fields=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields','custom_field','');
	$pw_sf_taxonomies=(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_taxonomy']['taxonomy_checkbox']) ? $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_taxonomy']['taxonomy_checkbox']:'');
	
	$pw_sf_post_per_page=(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_per_page']) ? ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_per_page']!='' ? $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_per_page']:'-1'):'-1');
	
	$pw_sf_search_position=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'];
	$pw_sf_pagination_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'];
	
	$pw_sf_switch_icon=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_switch_icon','custom_field','off');
	
	$pw_sf_taxonomy_id='';
	$pw_sf_taxonomy='';
	
	
	if(get_query_var('product_cat'!='') &&  !is_array(get_query_var('product_cat')))
	{
		//print_r(get_query_var('product_cat'));
		$pw_sf_taxonomy=get_query_var('product_cat');
		$term = get_term_by('slug', $pw_sf_taxonomy, 'product_cat');
		$pw_sf_taxonomy_id=$term->term_id;
		$pw_sf_taxonomy='product_cat';
		
	}else if(get_query_var('product_tag')!='' &&  !is_array(get_query_var('product_tag'))){
		$pw_sf_taxonomy=get_query_var('product_tag');
		$term = get_term_by('slug', $pw_sf_taxonomy, 'product_tag');
		$pw_sf_taxonomy_id=$term->term_id;
		$pw_sf_taxonomy='product_tag';
		
	}else if(get_query_var('taxonomy')!=''){
		$pw_sf_taxonomy=get_query_var( 'taxonomy' );
		$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
		$pw_sf_taxonomy_id=$term->term_id;
	}else if(get_query_var('pw_woo_taxonomy')!=''){
		$pw_sf_taxonomy=get_query_var( 'pw_woo_taxonomy' );
		$term = get_term_by( 'slug', get_query_var(get_query_var( 'pw_woo_taxonomy' )), get_query_var('pw_woo_taxonomy') );
		$pw_sf_taxonomy_id=$term->term_id;
	}
	else
	{
		$pw_sf_taxonomy_id='';
	}
		
	
	/*if(!empty($pw_sf_taxonomy))
	{
		$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
		$pw_sf_taxonomy_id=$term->term_id;
	}else
	{
		$pw_sf_taxonomy_id='';
	}*/
	
	$rand_id='_'.rand(0,1000);
	$pw_sf_target_element_id=$pw_sf_part.'_result'.$rand_id;
	
	$args=array(
		'pw_sf_rand_id'         		  => $rand_id,
		'pw_sf_shortcode_id'       		  => $pw_sf_shortcode_id,
		'pw_sf_post_type'         		  => $pw_sf_post_type,
		'pw_sf_part'			  		  => $pw_sf_part,
		'pw_sf_fields'					  => $pw_sf_fields,
		'pw_sf_taxonomies'				  => $pw_sf_taxonomies,
		'pw_sf_type'			 		  => $pw_sf_search_position,
		'pw_sf_display_type'	  		  => $pw_sf_display_type,
		'pw_sf_grid_type'				  => $pw_sf_grid_type,
		'pw_sf_orders'					  => $pw_sf_orders,
		'pw_sf_order_type'				  => $pw_sf_order_type,
		'pw_sf_post_per_page'    		  => $pw_sf_post_per_page,
		'pw_sf_pagination_type'  		  => $pw_sf_pagination_type,
		'pw_sf_target_element_id' 		  => $pw_sf_target_element_id,
		'pw_sf_switch_icon'	   			  => $pw_sf_switch_icon,
		'pw_sf_build_query_shortcode'	  => '',
		'pw_sf_taxonomy'	   		  	  => $pw_sf_taxonomy,
		'pw_sf_taxonomy_id'	   			  => $pw_sf_taxonomy_id,
		'pw_sf_other_args'		   		  => '',
	);
	
	//die(print_r($args));
	//print_r($args);
	//APPLY DYNAMIC CSS
	add_action( 'wp_enqueue_scripts', 'custom_style',10,2 );
	do_action('wp_enqueue_scripts',$pw_sf_shortcode_id , $rand_id);
	
	$final_output=$pw_woo_ad_main_class->build_search_form_html($args);
	
	$final_output.='
    <div class="main-container-wrapper">';
	if ($pw_sf_display_type=='style_1'): ?>
	<?php if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type']=='outer_item'): 
			$equal_height='';
			if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'equal_height']) && $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'equal_height']=='on'):
				$equal_height='woo-grid-style-equal-height';
				/*$final_output.='<style>
						.woo-grid-style-equal-height .woo-product-cnt{opacity: 0;}
					</style>';*/
			endif;		
	
	$final_output.='	<div  class="woo-row woogrid woo-grid-style '.$equal_height.' '.(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_masonry']) ? 'pl-masonry-grid':'').' '.($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display']=='masonry_grid' ? 'pl-masonry-grid':'').' wg-grid-'.$rand_id.'" id="'.$pw_sf_target_element_id.'">';
	 endif;
	if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type']=='over_item'): 
		 $final_output.='<div class="svg-grid woo-row woogrid woo-boxed-style '.($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display']=='masonry_grid' ? 'pl-masonry-grid':'').'  wg-boxed-'.$rand_id.'" id="'.$pw_sf_target_element_id.'"> ';
	endif;
	endif;
	if ($pw_sf_display_type=='style_2'): 
			$final_output.='<div  class="woo-row woogrid woo-list-style wg-list-'.$rand_id.'" id="'.$pw_sf_target_element_id.'">';
	 endif; 
	if ($pw_sf_display_type=='style_3'): 
		$final_output.='<div class="woo-row woogrid woo-style-1 wg-colored-'.$rand_id.'" id="'.$pw_sf_target_element_id.'">';
	endif;
	if ($pw_sf_display_type=='style_4'):
		$final_output.='<table class="wg-product-table woogrid wg-table-'.$rand_id.'" id="'.$pw_sf_target_element_id.'">';
	endif;
    
	
	 if ($pw_sf_display_type=='style_4'): 
		$final_output.='</table>';
	endif; 
	
	 if ($pw_sf_display_type=='default_theme'): 
		$final_output.='<div id="'.$pw_sf_target_element_id.'"></div>';
	 endif; 
	
	
	
		 
	if ($pw_sf_display_type=='style_1' || $pw_sf_display_type=='style_2' || $pw_sf_display_type=='style_3'): 
		$final_output.= '</div>';
	endif; 
	
    $final_output.='</div><!--main-container-wrapper -->';
	
	$loading_content='<i class="fa fa-refresh fa-3x fa-spin"></i>';

	if(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_type')!='')
	{
		$loading_type=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_type');
		
		if($loading_type=='loading_pack'){
			$loading_value=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_pack').".gif";
			$loading_content='<img src="'.__PW_WOO_AD_SEARCH_URL__.'/assets/images/loading-icon/'.$loading_value.'" />';
		}else if($loading_type=='upload'){
			$loading_value=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'upload_loading_icon');
			
			$loading_content=wp_get_attachment_image( $loading_value);
		}
	}
	
	$loading_color=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_color')!='' ? get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_color'):"#ffffff");
	
	
	$final_output.= '<div class="loading-cnt loadd" style="background:'.$loading_color.'"><div class="le-loading" >'.$loading_content.'</div></div>
	
	<!-- Element to pop up -->
	<div id="pw_woo_ad_search_popup_main" style="display:none">
		<span class="pw_woo_ad_search_popup_button pw_woo_ad_search_popup_close b-close">
			<span><i class="fa fa-times"></i></span>
		</span>
		<div id="pw_woo_ad_search_popup_content"></div>
	</div>';
?>


