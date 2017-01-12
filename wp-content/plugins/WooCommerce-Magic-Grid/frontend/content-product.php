<?php global $pw_woo_ad_main_class; ?>
<?php 
	//$rand_id= rand(0,1000);
	
	$rand_id=$pw_sf_rand_id;
	
	if(!isset($pw_sf_display_type))
		$pw_sf_display_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style'];
	$default_style=$pw_sf_display_type;
	
?>

<?php
	
	$row_counter=1; 
	
	$counter=0;
	
	if(($pw_sf_pagination_type=='pagination_showmore' || $pw_sf_pagination_type=='pagination_infinite' ) && $pw_sf_pagination_paged>1)
	{
		$counter=$pw_sf_pagination_paged*$pw_sf_post_per_page;
		$counter=($pw_sf_pagination_paged-1)*$pw_sf_post_per_page;
	}
	
	global $wpdb,$pw_woo_ad_main_class,$post,$woocommerce;
	
	$color_number=0;
//	global $product;
	if($my_query->have_posts())
	{
		if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']) && ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style']!='style_2') && ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style']!='style_4') ){
			$car_ctrl_pos = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_ctrl_position'];
			echo '<div id="woo-car'.$rand_id.'" class="woo-owl-carousel woo-owl-theme '.$car_ctrl_pos.'">';
		}
		while ( $my_query->have_posts() ) {
			$title = $regular_price=$price=$add_to_cart=$sale_price=$stock_status=$cate=$tag=$sku=$featured=$src_featured=$image_gallery=$thumbnail_id=$price="";
			$my_query->the_post(); 
			$id=$my_query->post->ID;
			$title = get_the_title();
//			echo wc_get_template( 'loop/rating.php' );
//			echo $product->get_rating_html($id);


			
			$product = get_product($id);
			$price = $product->get_price_html();
			
			$product_excerpt = $product->post->post_excerpt;
			$product_permalink = $product->get_permalink();
			
			
			/*$add_to_cart_link= pw_woo_ad_search_add_to_cart_grid('link');
			$add_to_cart_has_tag_a=false;
			if(strpos($add_to_cart_link, 'href='))
				$add_to_cart_has_tag_a=true;
			
			$add_to_cart_label= pw_woo_ad_search_add_to_cart_grid('label');
			*/
			
			
			//NEW METHOD
			$product_bottun_icon_link=pw_woo_ad_search_add_to_cart_grid('btn_icon_type',$id);
			$product_bottun_text_link=pw_woo_ad_search_add_to_cart_grid('btn_text_type',$id);
			
			/*$add_to_cart_link= $product_bottun['url'];
			$add_to_cart_has_tag_a=false;
			if(strpos($add_to_cart_link, 'href='))
				$add_to_cart_has_tag_a=true;
			
			$add_to_cart_label= $product_bottun['label'];
			$add_to_cart_class= $product_bottun['class'];
			echo $product_bottun['handle'];*/
			
			
			$regular_price = get_post_meta( $id, '_regular_price',true);
			$sale_price = get_post_meta( $id, '_sale_price',true);						
			
			$cat =get_the_term_list( $id, 'product_cat' , '',' / ','');							
			
			$tag =get_the_term_list( $id, 'product_tag');
			$sku = get_post_meta( $id, '_sku',true);
			
			$featured = get_post_meta( $id, '_featured',true);
			
			$thumbnail_id = get_post_meta( $id, '_thumbnail_id',true);
			$src_featured = wp_get_attachment_image( $thumbnail_id, 'thumbnail');
			
			$stock_status = get_post_meta( $id, '_stock_status',true);
			$arr_img="";
			$arr_img=explode(',',get_post_meta( $id, '_product_image_gallery',true));
			
			
//			$img=get_the_post_thumbnail( $id, 'thumbnail' );
			//Get Image's
/*			$args = array(
				'post_type' => 'attachment',
				'numberposts' => -1,
				'post_status' => null,
				'post_parent' => $id
			);

*/		
			$icon_style=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'icon_style','custom_field','woo-roundicon');
			
			$image_eff = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'image_effect_type'];
			$thumbnail_size = '';
			$thumbnail_size =$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'thumbnail_size','custom_field','orginal_size');
			
			$image_ratio=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'image_ratio','custom_field','thumb-1-1');
			
			$thumbnail_id = get_post_meta( $id, '_thumbnail_id',true);
			$src_featured = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size ,0);						
			$img1=$img2=$src_featured;
			
			if($src_featured=='')
			{
				if(count($arr_img)>0)
					$img1=wp_get_attachment_image_src( $arr_img[0], $thumbnail_size,0);
				else
					$img1="";
				if(count($arr_img)>1)
					$img2=wp_get_attachment_image_src( $arr_img[1], $thumbnail_size ,0);
				else
					$img2=$img1;
					
				if($img1=='' && $img2=='')	
				{
					$img2[0]=$img1[0]=woocommerce_placeholder_img_src();
				}
				
			}else{
				if(count($arr_img)>0)
					$img2=wp_get_attachment_image_src( $arr_img[0], $thumbnail_size ,0);
				else
					$img2=$img1;
			}
			
			$desktop_col= $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_column_desktop'];
			$tablet_col = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_column_tablet'];
			$mobile_col = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_column_mobile']; 
            
			
			//woocommerce_placeholder_img();
				
		//	$attachments = get_posts( $args );
		//	 if ( $attachments ) {
				//attachment-$size
	//			$media_attr  = array('class'	=> " woo-zoomin");
	//			foreach ( $attachments as $attachment ) {
	//			   $image_gallery[]=wp_get_attachment_image( $attachment->ID, 'medium',0,$media_attr);
	//			  }
	//		 }
			 //echo $title;
			 if ($pw_sf_display_type=='style_1'): 

				 if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type']=='outer_item'): 
					if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display']=='fit_row_grid'){
						include('content-fit-grid.php');
					}
					else if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display']=='masonry_grid'){
						include('content-dif-grid.php');
					}
				 endif;
				 if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'grid_type']=='over_item'): 
					 if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display']=='fit_row_grid'){
						include('content-fit-boxed.php');
					}
					else if ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'default_display']=='masonry_grid'){
						include('content-dif-boxed.php');
					}
					
					 
				 endif;
             endif;
             if ($pw_sf_display_type=='style_2'): 
					include('content-list.php');
             endif; 
             if ($pw_sf_display_type=='style_3'): 
               		include('content-colored.php');
             endif; 
            
             if ($pw_sf_display_type=='style_4'): 
                    include('content-table.php');
             endif; 
			
			
			
			$row_counter++;	
			$counter++;
			$color_number++;
			//include('content-colored.php');
			
			
		}
		
		//End of Carousel
		if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']) && ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style']!='style_2') && ($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'frontend_style']!='style_4') ){
			echo '</div>';
			$car_desk_col = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_desk_cols'];
			$car_tablet_col = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_tablet_cols'];
			$car_mobile_col = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_mobile_cols'];
			$car_slide_speed = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_item_slide_speed'];
			$car_speed = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_item_speed'];
			$car_autoplay = (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_autoplay']))?'true':'false';
			$car_nav = (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls']) || isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination']))?'true':'false';
			
			
			echo '
			<script language="javascript">
				jQuery(document).ready(function() {
				  setTimeout(function(){
					  var owl = jQuery("#woo-car'.$rand_id.'");
					  owl.owlCarousel({
						  autoPlay: '.$car_autoplay.', //Set AutoPlay to 3 seconds
						  lazyLoad : true, //Lazy Load Image
						  slideSpeed :'.$car_slide_speed.',
						  paginationSpeed : '.$car_speed.', 
						  stopOnHover : true,
						  autoHeight : false,
						  items : '.$car_desk_col.', 
						  itemsDesktop : [1200,'.$car_desk_col.'], 
						  itemsDesktopSmall : [992,'.$car_desk_col.'], 
						  itemsTablet: [991,'.$car_tablet_col.'], 
						  itemsMobile : [767,'.$car_mobile_col.'], 
						  navigation : '.$car_nav.' //Next/Prev Button
					  });
					  
					if(jQuery("html").find(".woo-style-1").length)
					{
						jQuery(".woo-overlay-cnt").responsiveEqualHeightGrid();
						jQuery(".woo-desc-cnt").responsiveEqualHeightGrid();
					}
					
				 	},100);
				  
				});
			</script>
			';
		}
		wp_reset_query();
	}
	else
	{
		echo $pw_woo_ad_main_class->alert('error',__('Nothing found!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__));
	}
?>

<?php

/*wp_enqueue_style('dynamic-css',admin_url('admin-ajax.php').'?action=dynamic_css');
function dynaminc_css() {
	require(__PW_ROOT_WOO_AD_SEARCH__.'/assets/css/front-end/custom-css.php');
	exit;
}
add_action('wp_ajax_dynamic_css', 'dynaminc_css');
add_action('wp_ajax_nopriv_dynamic_css', 'dynaminc_css');*/
?>       
<?php 
	//custom_style($shortcode_id , $rand_id);
	/*add_action( 'wp_enqueue_scripts', 'custom_style',10,2 );
	do_action('wp_enqueue_scripts',$shortcode_id , $rand_id);*/
?>