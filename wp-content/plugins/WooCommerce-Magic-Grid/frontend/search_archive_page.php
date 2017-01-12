<?php
	global $pw_woo_ad_main_class,$wpdb;
	
	if(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_default_archive_shortcode')!='')
	{
		
		$shortcode_id=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_default_archive_shortcode');

		$pw_woo_ad_main_class->fetch_custom_fields($shortcode_id);	
		
		$pw_sf_post_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_type'];

		$pw_sf_shortcode_id=$shortcode_id;
		
		$pw_sf_part='pw_woo_ad_grid_archive_page';
		
		$pw_sf_display_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'];
		$pw_sf_grid_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display'];
		
		$pw_sf_orders=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_orders','custom_field','');
		$pw_sf_order_type=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_order_type','custom_field','');
		
		$pw_sf_fields=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields','custom_field','');
		$pw_sf_taxonomies=(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_taxonomy']['taxonomy_checkbox']) ? $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_taxonomy']['taxonomy_checkbox']:'');
		
		$pw_sf_post_per_page=(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_per_page']) ? ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_per_page']!='' ? $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_per_page']:'-1'):'-1');
		
		$pw_sf_search_position=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_position'];
		$pw_sf_pagination_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_pagination'];
		
		$pw_sf_switch_icon=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'show_switch_icon','custom_field','off');
		
		
		
		$pw_sf_taxonomy=get_query_var( 'taxonomy' );
		if(!empty($pw_sf_taxonomy))
		{
			$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
			$pw_sf_taxonomy_id=$term->term_id;
		}else
		{
			$pw_sf_taxonomy_id='';
		}
		
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
		
		//APPLY DYNAMIC CSS
		add_action( 'wp_enqueue_scripts', 'custom_style',10,2 );
		do_action('wp_enqueue_scripts',$shortcode_id , $rand_id);
		
		$pw_woo_ad_main_class->build_search_form_html($args);
		
		if ($pw_sf_display_type=='style_1'): ?>
		<?php if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type']=='outer_item'): ?>
            <div  class="woo-row woogrid woo-grid-style <?php echo (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_masonry']))?'pl-masonry-grid':''; ?> <?php echo ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display']=='masonry_grid')?'pl-masonry-grid':''; ?> wg-grid-		
        <?php echo $rand_id;  ?>" id="<?php echo $pw_sf_target_element_id; ?>">
        <?php endif;?>
        <?php if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type']=='over_item'): ?>
             <div class="svg-grid woo-row woogrid woo-boxed-style <?php echo ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display']=='masonry_grid')?'pl-masonry-grid':''; ?>   wg-boxed-<?php echo $rand_id;  ?>" id="<?php echo $pw_sf_target_element_id; ?>"> 
        <?php endif;?>
        <?php endif;?>
        <?php if ($pw_sf_display_type=='style_2'): ?>
                <div  class="woo-row woogrid woo-list-style wg-list-<?php echo $rand_id; ?> " id="<?php echo $pw_sf_target_element_id; ?>">
        <?php endif; ?>
        <?php if ($pw_sf_display_type=='style_3'): ?>
            <div class="woo-row woogrid woo-style-1 wg-colored-<?php echo $rand_id;  ?>" id="<?php echo $pw_sf_target_element_id; ?>">
        <?php endif; ?>
        <?php if ($pw_sf_display_type=='style_4'): ?>
            <table class="wg-product-table woogrid wg-table-<?php echo $rand_id;  ?>" id="<?php echo $pw_sf_target_element_id; ?>">
        <?php endif; ?>
        <?php 
         if ($pw_sf_display_type=='style_4'): ?>	
        </table>
        <?php endif; 	 
             if ($pw_sf_display_type=='default_theme'): 
                echo '<div id="'.$pw_sf_target_element_id.'"></div>';
             endif; 
             
        if ($pw_sf_display_type=='style_1' || $pw_sf_display_type=='style_2' || $pw_sf_display_type=='style_3'): 
            echo '</div>';
        endif; 
		
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
		
		
		echo '<div class="loading-cnt loadd" style="background:'.$loading_color.'"><div class="le-loading" >'.$loading_content.'</div></div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					//jQuery(".pw-ad-codenegar-shop-loop-wrapper").remove();
				});
			</script>
		
		';
		
	}
	
	
	//CHEK ALL ON_OFF VARIABLE (DEFAULT VALUE)
	
?>