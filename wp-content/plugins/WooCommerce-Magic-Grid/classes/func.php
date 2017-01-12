<?php
if (!function_exists('pw_woo_ad_search_add_to_cart_grid')){
	function pw_woo_ad_search_add_to_cart_grid($type='',$id='') {
	global $product;
	
	$read_more_title=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title')=='' ? __('Read More',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'read_more_title'));
	
	$add_to_cart_title=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_cart_title')=='' ? __('Add To Cart',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'add_to_cart_title'));
	
	$select_options_title=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'select_options_title')=='' ? __('Select options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'select_options_title'));
	
	$view_options_title=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'view_options_title')=='' ? __('View options',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'view_options_title'));
	
	
	
	if($id!='')
		$product = get_product($id);
	
	if (!$product->is_in_stock()) :
		
		if($type=='link') :
			return apply_filters('out_of_stock_add_to_cart_url', get_permalink($product->id));
		elseif($type=='label')	:
			return apply_filters('not_purchasable_text', $read_more_title);
		endif;
		
	else :
		$link = array(
			'url' => '',
			'label' => '',
			'class' => '',
		);

		$handler = apply_filters('woocommerce_add_to_cart_handler', $product->product_type, $product);

		switch ($handler) {
			case "variable" :
				$link['url'] = apply_filters('variable_add_to_cart_url', get_permalink($product->id));
				$link['label'] = apply_filters('variable_add_to_cart_text wt-addtocart', $select_options_title);
				$link['class'] = apply_filters('add_to_cart_class', 'button  product_type_variable');
				break;
			case "grouped" :
				$link['url'] = apply_filters('grouped_add_to_cart_url', get_permalink($product->id));
				$link['label'] = apply_filters('grouped_add_to_cart_text', $view_options_title);
				$link['class'] = apply_filters('add_to_cart_class', 'button  product_type_simple');
				break;
			case "external" :
				$link['url'] = apply_filters('external_add_to_cart_url', get_permalink($product->id));
				$link['label'] = $product->get_button_text();
				$link['class'] = apply_filters('add_to_cart_class', 'button  product_type_simple');
				break;
			default :
				if ($product->is_purchasable()) {
					$link['url'] = apply_filters('add_to_cart_url', esc_url($product->add_to_cart_url()));
					$link['label'] = apply_filters('add_to_cart_text', $add_to_cart_title);
					$link['class'] = apply_filters('add_to_cart_class', 'button add_to_cart_button product_type_simple');
				} else {
					$link['url'] = apply_filters('not_purchasable_url', get_permalink($product->id));
					$link['label'] = apply_filters('not_purchasable_text', $read_more_title);
					$link['class'] = apply_filters('add_to_cart_class', 'button  product_type_simple');
				}
				break;
		}
		
		if($type=='link')
			return apply_filters('woocommerce_loop_add_to_cart_link', esc_url($link['url']));
		else if($type=='label')	
			return $link['label'];

		if(strpos($link['url'], 'href='))
		{
			$add_to_cart_has_tag_a=true;
			return apply_filters('woocommerce_loop_add_to_cart_link', esc_url($link['url']));
		}
		else if($type=='btn_icon_type'){
		
			return apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<div class="woo-addcart" title="%s"><a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s  product_type_%s" title="%s"></a></div>', esc_html($link['label']),esc_url($link['url']), esc_attr($product->id), esc_attr($product->get_sku()), esc_attr($link['class']), esc_attr($product->product_type), esc_html($link['label'])), $product, $link);
		
		}else if($type=='btn_text_type'){
			
			return apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s  product_type_%s">%s</a>', esc_url($link['url']), esc_attr($product->id), esc_attr($product->get_sku()), esc_attr($link['class']), esc_attr($product->product_type), esc_html($link['label'])), $product, $link);
			
		}
		

	endif;
	}
}
	function pw_woo_ad_search_rating_grid($id)
	{
	    global $post,$wpdb;		
		$count = $wpdb->get_var("
			SELECT COUNT(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = $id
			AND comment_approved = '1'
			AND meta_value > 0
		");
	
		$rating = $wpdb->get_var("
			SELECT SUM(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = $id
			AND comment_approved = '1'
		");
		$rate="";
		if ( $count > 0 ) {
		
			$average = number_format($rating / $count, 2);
		
			$rate.= '<div class="wg-starwrapper" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
		
			$rate.= '<span class="wg-star-rating" title="'.sprintf(__('Rated %s out of 5', 'woocommerce'), $average).'"><span style="width:'.($average*16).'%"><span itemprop="ratingValue" class="rating">'.$average.'</span> </span></span>';
			
					$rate.='<a href="#reviews" class="wg-woocommerce-review-link" rel="nofollow"><span itemprop="ratingCount" class="count">'.$count.'</span> '.__('REVIEW' , __PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</a>';
			$rate.= '</div>';
		}
		return $rate;		
	}


function custom_style($shortcode_id , $rand_id ){
	global $pw_woo_ad_main_class;

	wp_enqueue_style('pw-pl-custom-style', __PW_WOO_AD_SEARCH_CSS__ . '/custom.css', array() , null); 
	
	//CAROUSEL STYLE
	$car_control_display = (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_controls']))?'display:block':'display:none';
	$car_paging_display = (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination']))?'display:block':'display:none';
	$car_item_margin = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_item_margin','custom_field','10');
	
	$carousel_ctrl_color = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_ctrl_color'];
		$car_ctrl_back=$carousel_ctrl_color['bg-color'];
		$car_ctrl_hback = $carousel_ctrl_color['bg-hcolor'];
		$car_ctrl_color = $carousel_ctrl_color['text-color'];
		$car_ctrl_hcolor = $carousel_ctrl_color['text-hcolor'];
	//control radius
	$carousel_ctrl_radius = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_ctrl_radius'];
		$car_ctrl_top_radius = $carousel_ctrl_radius['top'];
		$car_ctrl_right_radius = $carousel_ctrl_radius['right'];
		$car_ctrl_left_radius = $carousel_ctrl_radius['left'];
		$car_ctrl_bottom_radius = $carousel_ctrl_radius['right'];
	
	$carousel_paging_color = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_paginatio_color'];
	$car_paging_back=$carousel_paging_color['color-from'];
	$car_paging_hback = $carousel_paging_color['color-to'];
	$car_paging_pos= $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination_position'];
	//control radius
	$carousel_paging_radius = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'carousel_pagination_radius'];
		$car_paging_top_radius = $carousel_paging_radius['top'];
		$car_paging_right_radius = $carousel_paging_radius['right'];
		$car_paging_left_radius = $carousel_paging_radius['left'];
		$car_paging_bottom_radius = $carousel_paging_radius['right'];
		
	/*$car_radius = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'border_radius_set','custom_field','');
	
	$border_radius_top = (isset($radius['top']))?$radius['top'].'px':'0px';
	$border_radius_bottom = (isset($radius['bottom']))?$radius['bottom'].'px':'0px';
	$border_radius_right = (isset($radius['right']))?$radius['right'].'px':'0px';
	$border_radius_left = (isset($radius['left']))?$radius['left'].'px':'0px';*/
		
	
	
	
	//PAGINATION STYLE
	$paging_num_color = $paging_show_more ='';
	if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_number_color_set']))
		$paging_num_color = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_number_color_set'];
	
	if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_show_more_color_set']))
		$paging_show_more = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_show_more_color_set'];
	
	
	//GENERAL STYLES
	$overlay_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'overlay_background_set','custom_field','');
	$background_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'background_set','custom_field','');
	
	$border = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'border_set','custom_field','');
	$margin = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'margin_set','custom_field','');
	$padding = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'padding_set','custom_field','');
	
	$border_radius_top=$border_radius_right=$border_radius_bottom=$border_radius_left='';
	if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){
		$radius = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'border_radius_set','custom_field','');
		
		$border_radius_top = (isset($radius['top']))?$radius['top'].'px':'0px';
		$border_radius_bottom = (isset($radius['bottom']))?$radius['bottom'].'px':'0px';
		$border_radius_right = (isset($radius['right']))?$radius['right'].'px':'0px';
		$border_radius_left = (isset($radius['left']))?$radius['left'].'px':'0px';
		
	}
	
	$price_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'price_font_set','custom_field','');
	$title_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'title_font_set','custom_field','');
	$excerpt_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_font_set','custom_field','');
	$meta_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'meta_font_set','custom_field','');
	$general_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'font_set','custom_field','');
	$sale_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'banner_sale_font_set','custom_field','');
	$feature_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'banner_featured_font_set','custom_field','');
	$fav_style = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'favorite_icon_color','custom_field','');
	
	$btn_option = $pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'set_btn_option','custom_field','');
	
	$shadow_hor = $shadow_color = $shadow_opacity = $shadow_spread = $shadow_ver = $shadow_blur ='';
	if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow'])){
		$box_shadow_set=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_shadow_set','custom_field','');
		
		$shadow_hor = (isset($box_shadow_set['hor-len']))?$box_shadow_set['hor-len'].'px':'0px';
		$shadow_ver = (isset($box_shadow_set['ver-len']))?$box_shadow_set['ver-len'].'px':'0px';
		$shadow_blur = (isset($box_shadow_set['blur-radius']))?$box_shadow_set['blur-radius'].'px':'0px';
		$shadow_spread = (isset($box_shadow_set['spread-radius']))?$box_shadow_set['spread-radius'].'px':'0px';
		$shadow_opacity = (isset($box_shadow_set['opacity']))?$box_shadow_set['opacity']:'1';
		$shadow_type = ($box_shadow_set['type']=='inset')?'inset':'';
		if (isset($box_shadow_set['color'])) { 
			list($r, $g, $b) = sscanf($box_shadow_set['color'], "#%02x%02x%02x"); 
			$shadow_color .='rgba('.$r.','.$g.','.$b.','.$shadow_opacity.')!important;';
		}
		
	}
	
	$imported_font = $price_family = $title_family = $excerpt_family = $meta_family =$general_family =$sale_family =$feature_family =array('inherit'); 
	
	if ($price_style['font-family']!='inherit') {
		$imported_font[] = $price_style['font-family']; 
		$price_family = explode(':',str_replace('+',' ',$price_style['font-family']));
	} 
	if ($title_style['font-family']!='inherit') {
		$imported_font[] = $title_style['font-family']; 
		$title_family = explode(':',str_replace('+',' ',$title_style['font-family']));
	}
	if ($excerpt_style['font-family']!='inherit') {
		$imported_font[] = $excerpt_style['font-family'];
		$excerpt_family = explode(':',str_replace('+',' ',$excerpt_style['font-family']));
	}
	if ($meta_style['font-family']!='inherit') {
		$imported_font[] = $meta_style['font-family'];
		$meta_family = explode(':',str_replace('+',' ',$meta_style['font-family']));
	} 
	if ($general_style['font-family']!='inherit') {
		$imported_font[] = $general_style['font-family']; 
		$general_family = explode(':',str_replace('+',' ',$general_style['font-family']));
	}
	if ($sale_style['font-family']!='inherit') {
		$imported_font[] = $sale_style['font-family']; 
		$sale_family = explode(':',str_replace('+',' ',$sale_style['font-family']));
	}
	if ($feature_style['font-family']!='inherit') {
		$imported_font[] = $feature_style['font-family']; 
		$feature_family = explode(':',str_replace('+',' ',$feature_style['font-family']));
	}

	$imported_font= array_filter(array_unique($imported_font));
	$sep='|';$font_family='';
	foreach ( $imported_font as $font ){
		if ($font_family==''){$sep='';}
		if ($font!='inherit')
			$font_family .= $sep . $font;
		$sep='|';
	}
 
	$custom_css = '
		';
		
		if (($font_family!='inherit') && ($font_family!='')){
			$custom_css .= '@import url(http://fonts.googleapis.com/css?family='. $font_family.');';
		}
		$custom_css .= '
		/*CAROUSEL STYLE*/
	
		#woo-car'.$rand_id.' .woo-car-item { margin:0 '.$car_item_margin.'px ; }
		#woo-car'.$rand_id.' .woo-owl-pagination{ '.$car_paging_display .'; text-align:'.$car_paging_pos.'; }
			#woo-car'.$rand_id.' .woo-owl-pagination .woo-owl-page span{ background:'.$car_paging_back.';-webkit-border-radius:'.$car_paging_top_radius.'px '.$car_paging_right_radius.'px '.$car_paging_left_radius.'px '. $car_paging_bottom_radius.'px;-moz-border-radius:'.$car_paging_top_radius.'px '.$car_paging_right_radius.'px '.$car_paging_left_radius.'px '. $car_paging_bottom_radius.'px;border-radius:'.$car_paging_top_radius.'px '.$car_paging_right_radius.'px '.$car_paging_left_radius.'px '. $car_paging_bottom_radius.'px; }
			#woo-car'.$rand_id.' .woo-owl-pagination .woo-owl-page:hover span,#woo-car'.$rand_id.' .woo-owl-pagination .woo-owl-page.active  span{ background:'.$car_paging_hback.'; }
		
		
		#woo-car'.$rand_id.' .woo-owl-buttons{ '.$car_control_display .'  }
			#woo-car'.$rand_id.' .woo-owl-buttons .woo-owl-prev , #woo-car'.$rand_id.' .woo-owl-buttons .woo-owl-next{ background:'.$car_ctrl_back.'; color:'.$car_ctrl_color.'; -webkit-border-radius:'.$car_ctrl_top_radius.'px '.$car_ctrl_right_radius.'px '.$car_ctrl_left_radius.'px '. $car_ctrl_bottom_radius.'px;-moz-border-radius:'.$car_ctrl_top_radius.'px '.$car_ctrl_right_radius.'px '.$car_ctrl_left_radius.'px '. $car_ctrl_bottom_radius.'px;border-radius:'.$car_ctrl_top_radius.'px '.$car_ctrl_right_radius.'px '.$car_ctrl_left_radius.'px '. $car_ctrl_bottom_radius.'px; }
			#woo-car'.$rand_id.' .woo-owl-buttons .woo-owl-prev:hover , #woo-car'.$rand_id.' .woo-owl-buttons .woo-owl-next:hover{ background:'.$car_ctrl_hback.'; color:'.$car_ctrl_hcolor.'; }
		/*WIDGET BUTTON OPTION*/
		.widget-btn  {';
			if (isset($btn_option['bg-color'])) $custom_css .='background:'.$btn_option['bg-color'].'!important;';
			if (isset($btn_option['text-color'])) $custom_css .='color:'.$btn_option['text-color'].'!important;';
		$custom_css .='}
		.widget-btn:hover  {';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='background:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['text-hcolor'])) $custom_css .='color:'.$btn_option['text-hcolor'].'!important;';
		$custom_css .='}
		/*
		//////////////////////TOOLTIP STYLE///////////////////
		*/
		.woo-tipsy-arrow-e{'; 
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color'])) {
				 $custom_css .='border-left-color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color','custom_field','').'!important;';
			}
		$custom_css .= '}
		
		.woo-tipsy-arrow-s{'; 
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color'])) {
				 $custom_css .='border-top-color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color','custom_field','').'!important;';
			}
		$custom_css .= '}
		.woo-tipsy-arrow-n{'; 
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color'])) {
				 $custom_css .='border-bottom-color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color','custom_field','').'!important;';
			}
		$custom_css .= '}
		.woo-tipsy-inner{'; 
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color'])) {
				 $custom_css .='background-color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_bg_color','custom_field','').'!important;';
			}
		$custom_css .= '}
		.woo-tipsy-inner{'; 
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_text_color'])) $custom_css .='color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tooltip_text_color','custom_field','').'!important;';
		$custom_css .= '}
		/*
		//////////////////////QUICK VIEW STYLE///////////////////
		*/
		.popup_quickview , .popup_sendto{'; 
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'popup_bg_color'])) $custom_css .='background-color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'popup_bg_color','custom_field','').'!important;';
		$custom_css .= '}
		.b-modal , .lightboxOverlay{'; 
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'popup_overlay_color'])) $custom_css .='background-color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'popup_overlay_color','custom_field','').'!important;';
		$custom_css .= '}
		
		.woo-quick-title a{'; 
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].';';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px;';
			if (isset($title_style['font-family'])) $custom_css .= ($title_family[0]!='inherit')?'font-family:"'.$title_family[0].'";':' ';
		$custom_css .= '}
			.woo-quick-title a:hover{'; 
				if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].';';
			$custom_css .= '}
		.woo-quick-price{'; 
			if (isset($price_style['color'])) $custom_css .='color:'.$price_style['color'].';';
			if (isset($price_style['size'])) $custom_css .='font-size:'.$price_style['size'].'px;';
			if (isset($price_style['font-family'])) $custom_css .=($price_family[0]!='inherit')?'font-family:"'.$price_family[0].'";':'';
		$custom_css .= '}
		.woo-quick-excerpt{'; 
			if (isset($excerpt_style['color'])) $custom_css .='color:'.$excerpt_style['color'].';';
			if (isset($excerpt_style['size'])) $custom_css .='font-size:'.$excerpt_style['size'].'px;';
			if (isset($excerpt_style['font-family'])) $custom_css .=($excerpt_family[0]!='inherit')?'font-family:"'.$excerpt_family[0].'";':'';
		$custom_css .= '}
		
		.woo-quick-cat a , .woo-quick-tag a {';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].';';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px;';
			if (isset($meta_style['font-family'])) $custom_css .=($meta_family[0]!='inherit')?'font-family:"'.$meta_family[0].'";':'';
		$custom_css .='}
		.woo-quick-cat a , .woo-quick-tag a {';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].';';
		$custom_css .='}
		
		
		.woo-quick-rating .wg-star-rating , .woo-quick-rating .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].';';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .=($general_family[0]!='inherit')?'font-family:"'.$general_family[0].'";':'';
		$custom_css .='}
		
		
		/*TABLE BUTTON OPTION*/
		.woo-quick-add .woo-addcard-btn a , .popup_sendto .search-submit  {';
			if (isset($btn_option['bg-color'])) $custom_css .='background:'.$btn_option['bg-color'].'!important;';
			if (isset($btn_option['text-color'])) $custom_css .='color:'.$btn_option['text-color'].'!important;';
		$custom_css .='}
		.woo-quick-add .woo-addcard-btn a:hover, .popup_sendto .search-submit:hover {';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='background:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['text-hcolor'])) $custom_css .='color:'.$btn_option['text-hcolor'].'!important;';
		$custom_css .='}
		
		
		/*
		//////////////////////PAGINATION STYLE//////////////////
		*/
		#pagination-cnt'.$rand_id.' .pagination > li > span {';
			if (isset($paging_num_color['bg-color'])){
				$custom_css.='background:'.$paging_num_color['bg-color'].';';
			}
			if (isset($paging_num_color['text-color'])){
				$custom_css.='color:'.$paging_num_color['text-color'].';';
			}
			if (isset($paging_num_color['border-color'])){
				$custom_css.='border-color:'.$paging_num_color['border-color'].'!important;';
			}
		$custom_css.='}
		#pagination-cnt'.$rand_id.' .pagination > li > span:hover {';
			if (isset($paging_num_color['bg-hcolor'])){
				$custom_css.='background:'.$paging_num_color['bg-hcolor'].';';
			}
			if (isset($paging_num_color['text-hcolor'])){
				$custom_css.='color:'.$paging_num_color['text-hcolor'].';';
			}
			if (isset($paging_num_color['border-color'])){
				$custom_css.='border-color:'.$paging_num_color['border-color'].'!important;';
			}
		$custom_css.='}
		#pagination-cnt'.$rand_id.' .pagination > .active > span , #pagination-cnt'.$rand_id.' .pagination > .active > span:hover{';
			if (isset($paging_num_color['active_bg-color'])){
				$custom_css.='background:'.$paging_num_color['active_bg-color'].'!important;';
			}
			if (isset($paging_num_color['active_bg-color'])){
				$custom_css.='color:'.$paging_num_color['active-text-color'].'!important;';
			}
		$custom_css.='}
		
		/*Show More*/
		
		.showmore-btn.pw_pl_load_more'.$rand_id.' {';
			
			if (isset($paging_show_more['bg-color'])){
				$custom_css.='background:'.$paging_show_more['bg-color'].'!important;';
			}
			if (isset($paging_show_more['text-color'])){
				$custom_css.='color:'.$paging_show_more['text-color'].'!important;';
			}
			if (isset($paging_show_more['border-color'])){
				$custom_css.='border-color:'.$paging_show_more['border-color'].'!important;';
			}
		$custom_css.='}
		.showmore-btn.showmore-btn.pw_pl_load_more'.$rand_id.':hover {';
			if (isset($paging_show_more['bg-hcolor'])){
				$custom_css.='background:'.$paging_show_more['bg-hcolor'].'!important;';
			}
			if (isset($paging_show_more['text-hcolor'])){
				$custom_css.='color:'.$paging_show_more['text-hcolor'].'!important;';
			}
			if (isset($paging_show_more['border-color'])){
				$custom_css.='border-color:'.$paging_show_more['border-color'].'!important;';
			}
		$custom_css.='}
		/*SEARCH QUERY STYLE*/
		
		
		#pw_woo_ad_grid_result'.$rand_id.'_yoursearch  span{';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_title_color'])){
				$custom_css.='color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_title_color','custom_field','').'!important;';
			}
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_fontsize'])){
				$custom_css.='font-size:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_fontsize','custom_field','').'px!important;';
			}
		$custom_css.='}
		#pw_woo_ad_grid_result'.$rand_id.'_yoursearch  span.ys_items {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_value_color'])){
				$custom_css.='color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_value_color','custom_field','').'!important;';
			}
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_fontsize'])){
				$custom_css.='font-size:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'yoursearch_fontsize','custom_field','').'px!important;';
			}
		$custom_css.='}
		/*
		//////////////////////TABLE STYLES////////////////
		*/
		.wg-table-'.$rand_id.' thead tr th{';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_head_background_color'])){
				$custom_css.='background-color: '.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_head_background_color','custom_field','').';';
			}
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_head_text_color'])){
				$custom_css.='color: '.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_head_text_color','custom_field','').';';
			}
		$custom_css.='
		}
		.wg-table-'.$rand_id.' tr:nth-child(even) , .wg-table-'.$rand_id.' tr:nth-child(odd){';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_background_color'])){
				$custom_css.='background-color: '.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_background_color','custom_field','').'!important;';
			}
		$custom_css.='
		}
			.wg-table-'.$rand_id.' tr:nth-child(even):hover , .wg-table-'.$rand_id.' tr:nth-child(odd):hover{';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_hover_row_color'])){
				$custom_css.='background-color: '.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_hover_row_color','custom_field','').'!important;';
			}
			$custom_css.='
			}
			.wg-table-'.$rand_id.' td {';
				
				if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_border_color'])){
					 $custom_css .= 'border-left-color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_border_color','custom_field','').'!important;
					 border-top-color:'.$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_border_color','custom_field','').'!important;';
				}
			$custom_css .=
			'}
			
			
		.wg-table-'.$rand_id.' .woo-product-delprice del , .wg-table-'.$rand_id.' .woo-product-price{';
			if (isset($price_style['color'])) $custom_css .='color:'.$price_style['color'].';';
			if (isset($price_style['size'])) $custom_css .='font-size:'.$price_style['size'].'px;';
			if (isset($price_style['font-family'])) $custom_css .=($price_family[0]!='inherit')?'font-family:"'.$price_family[0].'";':'';
		$custom_css .='}
		
		.wg-table-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px;';
			if (isset($title_style['font-family'])) $custom_css .= ($title_family[0]!='inherit')?'font-family:"'.$title_family[0].'";':'';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-product-title a:hover{';
			if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].';';
		$custom_css .='}
		
		
		.wg-table-'.$rand_id.' .woo-product-desc{';
			if (isset($excerpt_style['color'])) $custom_css .='color:'.$excerpt_style['color'].';';
			if (isset($excerpt_style['size'])) $custom_css .='font-size:'.$excerpt_style['size'].'px;';
			if (isset($excerpt_style['font-family'])) $custom_css .=($excerpt_family[0]!='inherit')?'font-family:"'.$excerpt_family[0].'";':'';
		$custom_css .='}
		
		
		.wg-table-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px;';
			if (isset($meta_style['font-family'])) $custom_css .=($meta_family[0]!='inherit')?'font-family:"'.$meta_family[0].'";':'';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].';';
		$custom_css .='}
		
		
		.wg-table-'.$rand_id.', .wg-table-'.$rand_id.' .wg-star-rating ,.wg-table-'.$rand_id.' .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].';';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .=($general_family[0]!='inherit')?'font-family:"'.$general_family[0].'";':'';
		$custom_css .='}
		
		/*TABLE BUTTON OPTION*/
		.wg-table-'.$rand_id.' .woo-addfav-btn.back-btn a ,.wg-table-'.$rand_id.' .woo-addcard-btn.back-btn a, .wg-table-'.$rand_id.' .woo-btns.back-btn   {';
			if (isset($btn_option['bg-color'])) $custom_css .='background:'.$btn_option['bg-color'].'!important;';
			if (isset($btn_option['text-color'])) $custom_css .='color:'.$btn_option['text-color'].'!important;';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-addfav-btn.back-btn a:hover ,.wg-table-'.$rand_id.' .woo-addcard-btn.back-btn a:hover , .wg-table-'.$rand_id.' .woo-btns.back-btn:hover {';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='background:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['text-hcolor'])) $custom_css .='color:'.$btn_option['text-hcolor'].'!important;';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-addfav-btn.outline-btn a ,.wg-table-'.$rand_id.' .woo-addcard-btn.outline-btn a, .wg-table-'.$rand_id.' .woo-btns.outline-btn {';
			if (isset($btn_option['bg-color'])) $custom_css .='border-color:'.$btn_option['bg-color'].'!important;';
			if (isset($btn_option['text-color'])) $custom_css .='color:'.$btn_option['text-color'].'!important;';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-addfav-btn.outline-btn a:hover ,.wg-table-'.$rand_id.' .woo-addcard-btn.outline-btn a:hover {';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='background:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='border-color:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['text-hcolor'])) $custom_css .='color:'.$btn_option['text-hcolor'].'!important;';
		$custom_css .='}
		
		
		/*TABLE FAV OPTION*/
		.wg-table-'.$rand_id.' .woo-addfav-btn i.pw-woo-ad-search-unfavorite{';
			if (isset($fav_style['color'])) $custom_css .='color:'.$fav_style['color'].'!important;';
		$custom_css .='}
			.wg-table-'.$rand_id.' .woo-addfav-btn:hover i.pw-woo-ad-search-unfavorite{';
				if (isset($fav_style['hcolor'])) $custom_css .='color:'.$fav_style['hcolor'].'!important;';
			$custom_css .='}
		.wg-table-'.$rand_id.' .woo-addfav-btn i.pw-woo-ad-search-favorite{';
			if (isset($fav_style['active-color'])) $custom_css .='color:'.$fav_style['active-color'].'!important;';
		$custom_css .='}
			.wg-table-'.$rand_id.' .woo-addfav-btn:hover i.pw-woo-ad-search-favorite{';
				if (isset($fav_style['active-hcolor'])) $custom_css .='color:'.$fav_style['active-hcolor'].'!important;';
			$custom_css .='}
			
		
		
		.wg-table-'.$rand_id.' .woo-banner.sale-banner{';
			if (isset($sale_style['bgcolor'])) $custom_css .='background:'.$sale_style['bgcolor'].'!important;';
			if (isset($sale_style['color'])) $custom_css .='color:'.$sale_style['color'].'!important;';
			if (isset($sale_style['size'])) $custom_css .='font-size:'.$sale_style['size'].'px!important;';
			if (isset($sale_style['font-family'])) $custom_css .=($sale_family[0]!='inherit')?'font-family:"'.$sale_family[0].'";':'';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-banner.feature-banner{';
			if (isset($feature_style['bgcolor'])) $custom_css .='background:'.$feature_style['bgcolor'].'!important;';
			if (isset($feature_style['color'])) $custom_css .='color:'.$feature_style['color'].'!important;';
			if (isset($feature_style['size'])) $custom_css .='font-size:'.$feature_style['size'].'px!important;';
			if (isset($feature_style['font-family'])) $custom_css .=($feature_family[0]!='inherit')?'font-family:"'.$feature_family[0].'";':'';
		$custom_css .='}
		
		
		/*TABELE RADIUS*/
		.wg-table-'.$rand_id.' thead tr th:first-child{ ';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:'.$border_radius_top.' 0 0 0 ;
					-moz-border-radius:'.$border_radius_top.' 0 0 0 ;
					-khtml-border-radius:'.$border_radius_top.' 0 0 0 ;
					-webkit-border-radius:'.$border_radius_top.' 0 0 0 ;
					';
			}
		$custom_css .='}
		.wg-table-'.$rand_id.' thead tr th:last-child { ';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:0 '.$border_radius_right.' 0 0 ;
					-moz-border-radius:0 '.$border_radius_right.' 0 0 ;
					-khtml-border-radius:0 '.$border_radius_right.' 0 0 ;
					-webkit-border-radius:0 '.$border_radius_right.' 0 0 ;
					';
			}
		$custom_css .='}	
		.wg-table-'.$rand_id.' tbody tr:last-child td:first-child{ ';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius: 0 0 0 '.$border_radius_bottom.';
					-moz-border-radius: 0 0 0 '.$border_radius_bottom.';
					-khtml-border-radius: 0 0 0 '.$border_radius_bottom.';
					-webkit-border-radius: 0 0 0 '.$border_radius_bottom.';
					';
			}
		$custom_css .='}
		.wg-table-'.$rand_id.' tbody tr:last-child td:last-child { ';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:0 0 '.$border_radius_left.' 0 ;
					-moz-border-radius:0 0 '.$border_radius_left.' 0 ;
					-khtml-border-radius:0 0 '.$border_radius_left.' 0 ;
					-webkit-border-radius:0 0 '.$border_radius_left.' 0 ;
					';
			}
		$custom_css .='}	
		
		
		
		/*BOXED STYlE EFFECT 3,4,5*/
		.wg-boxed-'.$rand_id.' svg path{';
			if (isset($overlay_style['color-from'])) { 
				list($r, $g, $b) = sscanf($overlay_style['color-from'], "#%02x%02x%02x"); 
				$custom_css .='fill:rgba('.$r.','.$g.','.$b.','.$overlay_style['opacity'].');';
			}
		$custom_css .='}
		
		/*BOXED STYlE EFFECT 1,2*/
		.wg-boxed-'.$rand_id.' .woo-boxed-eff-one .woo-overlay-cnt , .wg-boxed-'.$rand_id.' .woo-boxed-eff-two .woo-overlay-cnt{';
			if (isset($overlay_style['color-from'])) { 
				list($r, $g, $b) = sscanf($overlay_style['color-from'], "#%02x%02x%02x"); 
				$custom_css .='background:rgba('.$r.','.$g.','.$b.','.$overlay_style['opacity'].');';
			}
		$custom_css .='	}
		
		/*BOXED STYlE TEXT STYLE*/
		.wg-boxed-'.$rand_id.' .woo-product-delprice del , .wg-boxed-'.$rand_id.' .woo-product-price{';
			if (isset($price_style['color'])) $custom_css .='color:'.$price_style['color'].'!important;';
			if (isset($price_style['size'])) $custom_css .='font-size:'.$price_style['size'].'px!important;';
			if (isset($price_style['font-family'])) $custom_css .=($price_family[0]!='inherit')?'font-family:"'.$price_family[0].'";':'';
		$custom_css .='}
		
		.wg-boxed-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px!important;';
			if (isset($title_style['font-family'])) $custom_css .= ($title_family[0]!='inherit')?'font-family:"'.$title_family[0].'";':'';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-banner.sale-banner ,.wg-boxed-'.$rand_id.' .woo-banner.feature-banner ,.wg-boxed-'.$rand_id.' .woo-btns > div , .wg-boxed-'.$rand_id.' .woo-btns > div a {';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important; border-color:'.$title_style['color'].'!important;';
		$custom_css .='}
			
			.wg-boxed-'.$rand_id.' .woo-btns div:hover {';
				if (isset($title_style['hcolor'])) $custom_css .='border-color:'.$title_style['hcolor'].'!important;';
			$custom_css .='}
				.wg-boxed-'.$rand_id.' .woo-btns div:hover i , .wg-boxed-'.$rand_id.' .woo-btns div:hover a:before{';
					if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
				$custom_css .='}
		
		.wg-boxed-'.$rand_id.' .woo-product-title a:hover{';
			if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
		$custom_css .='}
		
		
		.wg-boxed-'.$rand_id.' .woo-product-desc{';
			if (isset($excerpt_style['color'])) $custom_css .='color:'.$excerpt_style['color'].'!important;';
			if (isset($excerpt_style['size'])) $custom_css .='font-size:'.$excerpt_style['size'].'px!important;';
			if (isset($excerpt_style['font-family'])) $custom_css .=($excerpt_family[0]!='inherit')?'font-family:"'.$excerpt_family[0].'";':'';
		$custom_css .='}
		
		
		.wg-boxed-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px!important;';
			if (isset($meta_style['font-family'])) $custom_css .=($meta_family[0]!='inherit')?'font-family:"'.$meta_family[0].'";':'';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].'!important;';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' , .wg-boxed-'.$rand_id.' .wg-star-rating ,.wg-boxed-'.$rand_id.' .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].'!important;';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .=($general_family[0]!='inherit')?'font-family:"'.$general_family[0].'";':'';
		$custom_css .='}
		
		
		/*BOXED STYLE MARGIN AND PADDING AND RADIUS*/
		.wg-boxed-'.$rand_id.' > div {';
			if (isset($margin['top'])) $custom_css .='margin-top:'.$margin['top'].'px!important;';
			if (isset($margin['bottom'])) $custom_css .='margin-bottom:'.$margin['bottom'].'px!important;';
			if (isset($margin['left'])) $custom_css .='padding-left:'.$margin['left'].'px!important;';
			if (isset($margin['right'])) $custom_css .='padding-right:'.$margin['right'].'px!important;';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-product-cnt {';
			if (isset($border['top'])) $custom_css .='border-top-width:'.$border['top'].'px!important;';
			if (isset($border['bottom'])) $custom_css .='border-bottom-width:'.$border['bottom'].'px!important;';
			if (isset($border['right'])) $custom_css .='border-right-width:'.$border['right'].'px!important;';
			if (isset($border['left'])) $custom_css .='border-left-width:'.$border['left'].'px!important;';
			if (isset($border['color'])) $custom_css .='border-color:'.$border['color'].'!important;';
			if (isset($border['type'])) $custom_css .='border-style:'.$border['type'].'!important;';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-product-cnt , .wg-boxed-'.$rand_id.' img , .wg-boxed-'.$rand_id.' .woo-product-cnt .woo-overlay-cnt{';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-moz-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-khtml-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-webkit-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					';
			}
		$custom_css .='}
		
		.wg-boxed-'.$rand_id.' .woo-product-cnt.woo-boxed-eff-three .woo-banner.sale-banner {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius: 0 0 0 '.$border_radius_bottom.';
					-moz-border-radius:0 0 0 '.$border_radius_bottom.';
					-khtml-border-radius:0 0 0 '.$border_radius_bottom.';
					-webkit-border-radius:0 0 0 '.$border_radius_bottom.';
					';
			}
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-product-cnt.woo-boxed-eff-three .woo-banner.feature-banner {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius: 0 0  '.$border_radius_left.' 0;
					-moz-border-radius:0 0'.$border_radius_left.' 0 ;
					-khtml-border-radius:0 0 '.$border_radius_left.' 0;
					-webkit-border-radius:0 0 '.$border_radius_left.' 0;
					';
			}
		$custom_css .='}
		.wg-boxed-'.$rand_id.'  .woo-product-cnt.woo-boxed-eff-three .woo-btns {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius: 0 0  '.$border_radius_left.' '.$border_radius_bottom .';
					-moz-border-radius: 0 0  '.$border_radius_left.' '.$border_radius_bottom .';
					-khtml-border-radius:0 0  '.$border_radius_left.' '.$border_radius_bottom .';
					-webkit-border-radius:0 0  '.$border_radius_left.' '.$border_radius_bottom .';
					';
			}
		$custom_css .='}
		
		.wg-boxed-'.$rand_id.' .woo-product-cnt.woo-boxed-eff-one .woo-overlay-cnt{';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius: 0 0  '.$border_radius_left.' '.$border_radius_bottom .';
					-moz-border-radius: 0 0  '.$border_radius_left.' '.$border_radius_bottom .';
					-khtml-border-radius: 0 0  '.$border_radius_left.' '.$border_radius_bottom .';
					-webkit-border-radius: 0 0  '.$border_radius_left.' '.$border_radius_bottom .';
					';
			}
		$custom_css .='}
		
		.wg-boxed-'.$rand_id.' .woo-product-cnt.woo-boxed-eff-two .woo-banner.sale-banner {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius: '.$border_radius_top.' 0 0 0 ;
					-moz-border-radius:'.$border_radius_top.' 0 0 0;
					-khtml-border-radius:'.$border_radius_top.' 0 0 0 ;
					-webkit-border-radius:'.$border_radius_top.' 0 0 0 ;
					';
			}
		$custom_css .='}
		.wg-boxed-'.$rand_id.'  .woo-product-cnt.woo-boxed-eff-two .woo-banner.feature-banner {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius: 0  '.$border_radius_right.' 0 0;
					-moz-border-radius: 0  '.$border_radius_right.' 0 0;
					-khtml-border-radius:0  '.$border_radius_right.' 0 0;
					-webkit-border-radius:0  '.$border_radius_right.' 0 0;
					';
			}
		$custom_css .='}
		
		/*BOXED SHADOW STYLES*/
		';
		if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow'])){
			$custom_css .='
				.wg-boxed-'.$rand_id.' .woo-product-cnt {
					-webkit-box-shadow:'.$shadow_type.' '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
					-moz-box-shadow: '.$shadow_type.' '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
					box-shadow:'.$shadow_type.'  '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
			}';
		}
		$custom_css .= '
		/*BOXED GENERAL STYLES*/
		.wg-boxed-'.$rand_id.' .woo-banner.sale-banner ,.wg-boxed-'.$rand_id.' .woo-banner.feature-banner , .wg-boxed-'.$rand_id.' .woo-btns {';
			if (isset($overlay_style['color-from'])) { 
				list($r, $g, $b) = sscanf($overlay_style['color-from'], "#%02x%02x%02x"); 
				$custom_css .='background:rgba('.$r.','.$g.','.$b.','.$overlay_style['opacity'].')!important;';
			}
		$custom_css .='}
		
		.wg-boxed-'.$rand_id.' .woo-banner.sale-banner{';
			if (isset($sale_style['bgcolor'])) $custom_css .='background:'.$sale_style['bgcolor'].'!important;';
			if (isset($sale_style['color'])) $custom_css .='color:'.$sale_style['color'].'!important;';
			if (isset($sale_style['size'])) $custom_css .='font-size:'.$sale_style['size'].'px!important;';
			if (isset($sale_style['font-family'])) $custom_css .=($sale_family[0]!='inherit')?'font-family:"'.$sale_family[0].'";':'';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-banner.feature-banner{';
			if (isset($feature_style['bgcolor'])) $custom_css .='background:'.$feature_style['bgcolor'].'!important;';
			if (isset($feature_style['color'])) $custom_css .='color:'.$feature_style['color'].'!important;';
			if (isset($feature_style['size'])) $custom_css .='font-size:'.$feature_style['size'].'px!important;';
			if (isset($feature_style['font-family'])) $custom_css .=($feature_family[0]!='inherit')?'font-family:"'.$feature_family[0].'";':'';
		$custom_css .='}
		
		/*BOXED FAV OPTION*/
		.wg-boxed-'.$rand_id.' .woo-addfav i.pw-woo-ad-search-unfavorite{';
			if (isset($fav_style['color'])) $custom_css .='color:'.$fav_style['color'].'!important;';
		$custom_css .='}
			.wg-boxed-'.$rand_id.' .woo-addfav:hover i.pw-woo-ad-search-unfavorite{';
				if (isset($fav_style['hcolor'])) $custom_css .='color:'.$fav_style['hcolor'].'!important;';
			$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-addfav i.pw-woo-ad-search-favorite{';
			if (isset($fav_style['active-color'])) $custom_css .='color:'.$fav_style['active-color'].'!important;';
		$custom_css .='}
			.wg-boxed-'.$rand_id.' .woo-addfav:hover i.pw-woo-ad-search-favorite{';
				if (isset($fav_style['active-hcolor'])) $custom_css .='color:'.$fav_style['active-hcolor'].'!important;';
			$custom_css .='}
		/*
		///////////////////// GRID STYLE ///////////////////////
		*/
		.wg-grid-'.$rand_id.' .woo-product-cnt {';
			if (isset($background_style['color-from'])) $custom_css .='background:'.$background_style['color-from'].'!important;';
		$custom_css .='}
			.wg-grid-'.$rand_id.' .woo-product-cnt:hover {';
				if (isset($background_style['color-to'])) $custom_css .='background:'.$background_style['color-to'].'!important;';
			$custom_css .='}
		
		/*GRID STYlE TEXT STYLE*/
		.wg-grid-'.$rand_id.' .woo-product-delprice del , .wg-grid-'.$rand_id.' .woo-product-price{';
			if (isset($price_style['color'])) $custom_css .='color:'.$price_style['color'].'!important;';
			if (isset($price_style['size'])) $custom_css .='font-size:'.$price_style['size'].'px!important;';
			if (isset($price_style['font-family'])) $custom_css .=($price_family[0]!='inherit')?'font-family:"'.$price_family[0].'";':'';
		$custom_css .='}
		
		.wg-grid-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px!important;';
			if (isset($title_style['font-family'])) $custom_css .= ($title_family[0]!='inherit')?'font-family:"'.$title_family[0].'";':'';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-banner.sale-banner ,.wg-grid-'.$rand_id.' .woo-banner.feature-banner ,.wg-grid-'.$rand_id.' .woo-btns > div , .wg-grid-'.$rand_id.' .woo-btns > div a {';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important; border-color:'.$title_style['color'].'!important;';
		$custom_css .='}
			
			.wg-grid-'.$rand_id.' .woo-btns > div a:hover i {';
				if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
			$custom_css .='}
		
		.wg-grid-'.$rand_id.' .woo-product-title a:hover{';
			if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
		$custom_css .='}
		
		
		.wg-grid-'.$rand_id.' .woo-product-desc{';
			if (isset($excerpt_style['color'])) $custom_css .='color:'.$excerpt_style['color'].'!important;';
			if (isset($excerpt_style['size'])) $custom_css .='font-size:'.$excerpt_style['size'].'px!important;';
			if (isset($excerpt_style['font-family'])) $custom_css .=($excerpt_family[0]!='inherit')?'font-family:"'.$excerpt_family[0].'";':'';
		$custom_css .='}
		
		
		.wg-grid-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px!important;';
			if (isset($meta_style['font-family'])) $custom_css .=($meta_family[0]!='inherit')?'font-family:"'.$meta_family[0].'";':'';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].'!important;';
		$custom_css .='}
		.wg-grid-'.$rand_id.' , .wg-grid-'.$rand_id.' .wg-star-rating ,.wg-grid-'.$rand_id.' .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].'!important;';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .=($general_family[0]!='inherit')?'font-family:"'.$general_family[0].'";':'';
		$custom_css .='}
		
		/*GRID STYLE MARGIN AND PADDING AND RADIUS*/
		.wg-grid-'.$rand_id.' > div {';
			if (isset($margin['top'])) $custom_css .='margin-top:'.$margin['top'].'px!important;';
			if (isset($margin['bottom'])) $custom_css .='margin-bottom:'.$margin['bottom'].'px!important;';
			if (isset($margin['left'])) $custom_css .='padding-left:'.$margin['left'].'px!important;';
			if (isset($margin['right'])) $custom_css .='padding-right:'.$margin['right'].'px!important;';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-product-cnt {';
			if (isset($padding['top'])) $custom_css .='padding-top:'.$padding['top'].'px!important;';
			if (isset($padding['bottom'])) $custom_css .='padding-bottom:'.$padding['bottom'].'px!important;';
			if (isset($padding['right'])) $custom_css .='padding-right:'.$padding['right'].'px!important;';
			if (isset($padding['left'])) $custom_css .='padding-left:'.$padding['left'].'px!important;';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-product-cnt {';
			if (isset($border['top'])) $custom_css .='border-top-width:'.$border['top'].'px!important;';
			if (isset($border['bottom'])) $custom_css .='border-bottom-width:'.$border['bottom'].'px!important;';
			if (isset($border['right'])) $custom_css .='border-right-width:'.$border['right'].'px!important;';
			if (isset($border['left'])) $custom_css .='border-left-width:'.$border['left'].'px!important;';
			if (isset($border['color'])) $custom_css .='border-color:'.$border['color'].'!important;';
			if (isset($border['type'])) $custom_css .='border-style:'.$border['type'].'!important;';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-product-cnt {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-moz-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-khtml-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-webkit-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					';
			}
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-product-cnt.wg-bottom-desc .woo-overlay-cnt , .wg-grid-'.$rand_id.' .woo-product-cnt.wg-bottom-desc img, .wg-grid-'.$rand_id.' .woo-product-cnt.wg-bottom-desc .woo-thumb-cnt {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:'.$border_radius_top.' '.$border_radius_right.' 0 0;
					-moz-border-radius:'.$border_radius_top.' '.$border_radius_right.' 0 0;
					-khtml-border-radius:'.$border_radius_top.' '.$border_radius_right.' 0 0 ;
					-webkit-border-radius:'.$border_radius_top.' '.$border_radius_right.' 0 0 ;
					';
			}
		$custom_css .='}
		
		/*GRID GENERAL STYLES*/
		.wg-grid-'.$rand_id.' .woo-banner.sale-banner ,.wg-grid-'.$rand_id.' .woo-banner.feature-banner  {';
			if (isset($background_style['color-from'])) { 
				list($r, $g, $b) = sscanf($background_style['color-from'], "#%02x%02x%02x"); 
				$custom_css .='background:rgba('.$r.','.$g.','.$b.',0.9)!important;';
			}
		$custom_css .='}
		
		.wg-grid-'.$rand_id.' .woo-banner.sale-banner{';
			if (isset($sale_style['bgcolor'])) $custom_css .='background:'.$sale_style['bgcolor'].'!important;';
			if (isset($sale_style['color'])) $custom_css .='color:'.$sale_style['color'].'!important;';
			if (isset($sale_style['size'])) $custom_css .='font-size:'.$sale_style['size'].'px!important;';
			if (isset($sale_style['font-family'])) $custom_css .=($sale_family[0]!='inherit')?'font-family:"'.$sale_family[0].'";':'';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-banner.feature-banner{';
			if (isset($feature_style['bgcolor'])) $custom_css .='background:'.$feature_style['bgcolor'].'!important;';
			if (isset($feature_style['color'])) $custom_css .='color:'.$feature_style['color'].'!important;';
			if (isset($feature_style['size'])) $custom_css .='font-size:'.$feature_style['size'].'px!important;';
			if (isset($feature_style['font-family'])) $custom_css .=($feature_family[0]!='inherit')?'font-family:"'.$feature_family[0].'";':'';
		$custom_css .='}
		
		/*GRID STYlE OVERLAY*/
		.wg-grid-'.$rand_id.' .woo-overlay-cnt    {';
			if (isset($overlay_style['color-from'])) { 
				list($r, $g, $b) = sscanf($overlay_style['color-from'], "#%02x%02x%02x"); 
				$custom_css .='background:rgba('.$r.','.$g.','.$b.','.$overlay_style['opacity'].');';
			}
		$custom_css .='	}
		
		/*GRID BUTTON OPTION*/
		.wg-grid-'.$rand_id.' .woo-addfav-btn.back-btn a ,.wg-grid-'.$rand_id.' .woo-addcard-btn.back-btn a, .wg-grid-'.$rand_id.' .woo-btns.back-btn   {';
			if (isset($btn_option['bg-color'])) $custom_css .='background:'.$btn_option['bg-color'].'!important;';
			if (isset($btn_option['text-color'])) $custom_css .='color:'.$btn_option['text-color'].'!important;';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-addfav-btn.back-btn a:hover ,.wg-grid-'.$rand_id.' .woo-addcard-btn.back-btn a:hover , .wg-grid-'.$rand_id.' .woo-btns.back-btn:hover {';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='background:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['text-hcolor'])) $custom_css .='color:'.$btn_option['text-hcolor'].'!important;';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-addfav-btn.outline-btn a ,.wg-grid-'.$rand_id.' .woo-addcard-btn.outline-btn a, .wg-grid-'.$rand_id.' .woo-btns.outline-btn {';
			if (isset($btn_option['bg-color'])) $custom_css .='border-color:'.$btn_option['bg-color'].'!important;';
			if (isset($btn_option['text-color'])) $custom_css .='color:'.$btn_option['text-color'].'!important;';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-addfav-btn.outline-btn a:hover ,.wg-grid-'.$rand_id.' .woo-addcard-btn.outline-btn a:hover {';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='background:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='border-color:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['text-hcolor'])) $custom_css .='color:'.$btn_option['text-hcolor'].'!important;';
		$custom_css .='}
		
		/*GRID FAV OPTION*/
		.wg-grid-'.$rand_id.' .woo-addfav-btn i.pw-woo-ad-search-unfavorite{';
			if (isset($fav_style['color'])) $custom_css .='color:'.$fav_style['color'].'!important;';
		$custom_css .='}
			.wg-grid-'.$rand_id.' .woo-addfav-btn:hover i.pw-woo-ad-search-unfavorite{';
				if (isset($fav_style['hcolor'])) $custom_css .='color:'.$fav_style['hcolor'].'!important;';
			$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-addfav-btn i.pw-woo-ad-search-favorite{';
			if (isset($fav_style['active-color'])) $custom_css .='color:'.$fav_style['active-color'].'!important;';
		$custom_css .='}
			.wg-grid-'.$rand_id.' .woo-addfav-btn:hover i.pw-woo-ad-search-favorite{';
				if (isset($fav_style['active-hcolor'])) $custom_css .='color:'.$fav_style['active-hcolor'].'!important;';
			$custom_css .='}
		/*GRID SHADOW STYLES*/
		';
		if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow'])){
			$custom_css .='
				.wg-grid-'.$rand_id.' .woo-product-cnt {
					-webkit-box-shadow:'.$shadow_type.' '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
					-moz-box-shadow: '.$shadow_type.' '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
					box-shadow:'.$shadow_type.'  '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
			}';
		}
		$custom_css .= '
		
		
		
		/*LIST STYlE TEXT STYLE*/
		.wg-list-'.$rand_id.' .woo-product-cnt {';
			if (isset($background_style['color-from'])) $custom_css .='background:'.$background_style['color-from'].'!important;';
		$custom_css .='}
			.wg-list-'.$rand_id.' .woo-product-cnt:hover {';
				if (isset($background_style['color-to'])) $custom_css .='background:'.$background_style['color-to'].'!important;';
			$custom_css .='}
			
		.wg-list-'.$rand_id.' .woo-product-delprice del , .wg-list-'.$rand_id.' .woo-product-price{';
			if (isset($price_style['color'])) $custom_css .='color:'.$price_style['color'].'!important;';
			if (isset($price_style['size'])) $custom_css .='font-size:'.$price_style['size'].'px!important;';
			if (isset($price_style['font-family'])) $custom_css .=($price_family[0]!='inherit')?'font-family:"'.$price_family[0].'";':'';
		$custom_css .='}
		
		.wg-list-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px!important;';
			if (isset($title_style['font-family'])) $custom_css .= ($title_family[0]!='inherit')?'font-family:"'.$title_family[0].'";':'';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-banner.sale-banner ,.wg-list-'.$rand_id.' .woo-banner.feature-banner ,.wg-list-'.$rand_id.' .woo-btns > div , .wg-list-'.$rand_id.' .woo-btns > div a {';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important; border-color:'.$title_style['color'].'!important;';
		$custom_css .='}
			
			.wg-list-'.$rand_id.' .woo-btns > div a:hover i {';
				if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
			$custom_css .='}
		
		.wg-list-'.$rand_id.' .woo-product-title a:hover{';
			if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
		$custom_css .='}
		
		
		.wg-list-'.$rand_id.' .woo-product-desc{';
			if (isset($excerpt_style['color'])) $custom_css .='color:'.$excerpt_style['color'].'!important;';
			if (isset($excerpt_style['size'])) $custom_css .='font-size:'.$excerpt_style['size'].'px!important;';
			if (isset($excerpt_style['font-family'])) $custom_css .=($excerpt_family[0]!='inherit')?'font-family:"'.$excerpt_family[0].'";':'';
		$custom_css .='}
		
		
		.wg-list-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px!important;';
			if (isset($meta_style['font-family'])) $custom_css .=($meta_family[0]!='inherit')?'font-family:"'.$meta_family[0].'";':'';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].'!important;';
		$custom_css .='}
		.wg-list-'.$rand_id.'  , .wg-list-'.$rand_id.' .wg-star-rating ,.wg-list-'.$rand_id.' .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].'!important;';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .=($general_family[0]!='inherit')?'font-family:"'.$general_family[0].'";':'';
		$custom_css .='}
		
		/*LIST STYLE MARGIN AND PADDING AND RADIUS*/
		.wg-list-'.$rand_id.' > div {';
			if (isset($margin['top'])) $custom_css .='margin-top:'.$margin['top'].'px!important;';
			if (isset($margin['bottom'])) $custom_css .='margin-bottom:'.$margin['bottom'].'px!important;';
		$custom_css .='}
		
		.wg-list-'.$rand_id.' .woo-product-cnt {';
			if (isset($padding['top'])) $custom_css .='padding-top:'.$padding['top'].'px!important;';
			if (isset($padding['bottom'])) $custom_css .='padding-bottom:'.$padding['bottom'].'px!important;';
			if (isset($padding['right'])) $custom_css .='padding-right:'.$padding['right'].'px!important;';
			if (isset($padding['left'])) $custom_css .='padding-left:'.$padding['left'].'px!important;';
			
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-product-cnt {';
			if (isset($border['top'])) $custom_css .='border-top-width:'.$border['top'].'px!important;';
			if (isset($border['bottom'])) $custom_css .='border-bottom-width:'.$border['bottom'].'px!important;';
			if (isset($border['right'])) $custom_css .='border-right-width:'.$border['right'].'px!important;';
			if (isset($border['left'])) $custom_css .='border-left-width:'.$border['left'].'px!important;';
			if (isset($border['color'])) $custom_css .='border-color:'.$border['color'].'!important;';
			if (isset($border['type'])) $custom_css .='border-style:'.$border['type'].'!important;';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-product-cnt {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-moz-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-khtml-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-webkit-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					';
			}
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-banner.sale-banner {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:'.$border_radius_top.' 0 0 0 ;
					-moz-border-radius:'.$border_radius_top.' 0 0 0 ;
					-khtml-border-radius:'.$border_radius_top.' 0 0 0 ;
					-webkit-border-radius:'.$border_radius_top.' 0 0 0 ;
					';
			}
		$custom_css .='}
		
		/*LIST GENERAL STYLES*/
		.wg-list-'.$rand_id.' .woo-banner.sale-banner ,.wg-list-'.$rand_id.' .woo-banner.feature-banner  {';
			if (isset($background_style['color-from'])) { 
				list($r, $g, $b) = sscanf($background_style['color-from'], "#%02x%02x%02x"); 
				$custom_css .='background:rgba('.$r.','.$g.','.$b.',0.9)!important;';
			}
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-banner.sale-banner{';
			if (isset($sale_style['bgcolor'])) $custom_css .='background:'.$sale_style['bgcolor'].'!important;';
			if (isset($sale_style['color'])) $custom_css .='color:'.$sale_style['color'].'!important;';
			if (isset($sale_style['size'])) $custom_css .='font-size:'.$sale_style['size'].'px!important;';
			if (isset($sale_style['font-family'])) $custom_css .=($sale_family[0]!='inherit')?'font-family:"'.$sale_family[0].'";':'';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-banner.feature-banner{';
			if (isset($feature_style['bgcolor'])) $custom_css .='background:'.$feature_style['bgcolor'].'!important;';
			if (isset($feature_style['color'])) $custom_css .='color:'.$feature_style['color'].'!important;';
			if (isset($feature_style['size'])) $custom_css .='font-size:'.$feature_style['size'].'px!important;';
			if (isset($feature_style['font-family'])) $custom_css .=($feature_family[0]!='inherit')?'font-family:"'.$feature_family[0].'";':'';
		$custom_css .='}
		/*LIST STYlE OVERLAY*/
		.wg-list-'.$rand_id.' .woo-overlay-cnt {';
			if (isset($overlay_style['color-from'])) { 
				list($r, $g, $b) = sscanf($overlay_style['color-from'], "#%02x%02x%02x"); 
				$custom_css .='background:rgba('.$r.','.$g.','.$b.','.$overlay_style['opacity'].');';
			}
		$custom_css .='	}
		
		/*LIST BUTTON OPTION*/
		.wg-list-'.$rand_id.' .woo-addfav-btn.back-btn a ,.wg-list-'.$rand_id.' .woo-addcard-btn.back-btn a, .wg-list-'.$rand_id.' .woo-btns.back-btn   {';
			if (isset($btn_option['bg-color'])) $custom_css .='background:'.$btn_option['bg-color'].'!important;';
			if (isset($btn_option['text-color'])) $custom_css .='color:'.$btn_option['text-color'].'!important;';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-addfav-btn.back-btn a:hover ,.wg-list-'.$rand_id.' .woo-addcard-btn.back-btn a:hover , .wg-list-'.$rand_id.' .woo-btns.back-btn:hover {';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='background:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['text-hcolor'])) $custom_css .='color:'.$btn_option['text-hcolor'].'!important;';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-addfav-btn.outline-btn a ,.wg-list-'.$rand_id.' .woo-addcard-btn.outline-btn a, .wg-list-'.$rand_id.' .woo-btns.outline-btn {';
			if (isset($btn_option['bg-color'])) $custom_css .='border-color:'.$btn_option['bg-color'].'!important;';
			if (isset($btn_option['text-color'])) $custom_css .='color:'.$btn_option['text-color'].'!important;';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-addfav-btn.outline-btn a:hover ,.wg-list-'.$rand_id.' .woo-addcard-btn.outline-btn a:hover {';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='background:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['bg-hcolor'])) $custom_css .='border-color:'.$btn_option['bg-hcolor'].'!important;';
			if (isset($btn_option['text-hcolor'])) $custom_css .='color:'.$btn_option['text-hcolor'].'!important;';
		$custom_css .='}
		
		/*TABLE FAV OPTION*/
		.wg-list-'.$rand_id.' .woo-addfav-btn i.pw-woo-ad-search-unfavorite{';
			if (isset($fav_style['color'])) $custom_css .='color:'.$fav_style['color'].'!important;';
		$custom_css .='}
			.wg-list-'.$rand_id.' .woo-addfav-btn:hover i.pw-woo-ad-search-unfavorite{';
				if (isset($fav_style['hcolor'])) $custom_css .='color:'.$fav_style['hcolor'].'!important;';
			$custom_css .='}
		.wg-list-'.$rand_id.' .woo-addfav-btn i.pw-woo-ad-search-favorite{';
			if (isset($fav_style['active-color'])) $custom_css .='color:'.$fav_style['active-color'].'!important;';
		$custom_css .='}
			.wg-list-'.$rand_id.' .woo-addfav-btn:hover i.pw-woo-ad-search-favorite{';
				if (isset($fav_style['active-hcolor'])) $custom_css .='color:'.$fav_style['active-hcolor'].'!important;';
			$custom_css .='}
		/*GRID SHADOW STYLES*/
		';
		if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow'])){
			$custom_css .='
				.wg-list-'.$rand_id.' .woo-product-cnt {
					-webkit-box-shadow:'.$shadow_type.' '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
					-moz-box-shadow: '.$shadow_type.' '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
					box-shadow:'.$shadow_type.'  '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
			}';
		}
		$custom_css .= '
		
		
		/*COLORED STYlE TEXT STYLE*/
		.wg-colored-'.$rand_id.' .woo-product-cnt {';
			if (isset($background_style['color-from'])) $custom_css .='background:'.$background_style['color-from'].'!important;';
		$custom_css .='}
		
		.wg-colored-'.$rand_id.' .woo-product-delprice del , .wg-colored-'.$rand_id.' .woo-product-price{';
			if (isset($price_style['color'])) $custom_css .='color:'.$price_style['color'].'!important;';
			if (isset($price_style['size'])) $custom_css .='font-size:'.$price_style['size'].'px!important;';
			if (isset($price_style['font-family'])) $custom_css .=($price_family[0]!='inherit')?'font-family:"'.$price_family[0].'";':'';
		$custom_css .='}
		
		.wg-colored-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px!important;';
			if (isset($title_style['font-family'])) $custom_css .= ($title_family[0]!='inherit')?'font-family:"'.$title_family[0].'";':'';
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-btns > div , .wg-colored-'.$rand_id.' .woo-btns > div a {';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important; border-color:'.$title_style['color'].'!important;';
		$custom_css .='}
			
			.wg-colored-'.$rand_id.' .woo-btns > div a:hover i {';
				if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
			$custom_css .='}
		
		.wg-colored-'.$rand_id.' .woo-product-title a:hover{';
			if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
		$custom_css .='}
		
		
		.wg-colored-'.$rand_id.' .woo-product-desc{';
			if (isset($excerpt_style['color'])) $custom_css .='color:'.$excerpt_style['color'].'!important;';
			if (isset($excerpt_style['size'])) $custom_css .='font-size:'.$excerpt_style['size'].'px!important;';
			if (isset($excerpt_style['font-family'])) $custom_css .=($excerpt_family[0]!='inherit')?'font-family:"'.$excerpt_family[0].'";':'';
		$custom_css .='}
		
		
		.wg-colored-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px!important;';
			if (isset($meta_style['font-family'])) $custom_css .=($meta_family[0]!='inherit')?'font-family:"'.$meta_family[0].'";':'';
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].'!important;';
		$custom_css .='}
		.wg-colored-'.$rand_id.', .wg-colored-'.$rand_id.' .wg-star-rating ,.wg-colored-'.$rand_id.' .wg-woocommerce-review-link   {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].'!important;';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .=($general_family[0]!='inherit')?'font-family:"'.$general_family[0].'";':'';
		$custom_css .='}
		
		.wg-colored-'.$rand_id.' .woo-banner.sale-banner   {';
			if (isset($sale_style['font-family'])) $custom_css .=($sale_family[0]!='inherit')?'font-family:"'.$sale_family[0].'";':'';
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-banner.feature-banner   {';
			if (isset($feature_style['font-family'])) $custom_css .=($feature_family[0]!='inherit')?'font-family:"'.$feature_family[0].'";':'';
		$custom_css .='}
		/*colored STYLE MARGIN AND PADDING AND RADIUS*/
		.wg-colored-'.$rand_id.' > div {';
			if (isset($margin['top'])) $custom_css .='margin-top:'.$margin['top'].'px!important;';
			if (isset($margin['bottom'])) $custom_css .='margin-bottom:'.$margin['bottom'].'px!important;';
			if (isset($margin['left'])) $custom_css .='padding-left:'.$margin['left'].'px!important;';
			if (isset($margin['right'])) $custom_css .='padding-right:'.$margin['right'].'px!important;';
		$custom_css .='}
		
		.wg-colored-'.$rand_id.' .woo-product-cnt {';
			if (isset($padding['top'])) $custom_css .='padding-top:'.$padding['top'].'px!important;';
			if (isset($padding['bottom'])) $custom_css .='padding-bottom:'.$padding['bottom'].'px!important;';
			if (isset($padding['right'])) $custom_css .='padding-right:'.$padding['right'].'px!important;';
			if (isset($padding['left'])) $custom_css .='padding-left:'.$padding['left'].'px!important;';
			
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-product-cnt {';
			if (isset($border['top'])) $custom_css .='border-top-width:'.$border['top'].'px!important;';
			if (isset($border['bottom'])) $custom_css .='border-bottom-width:'.$border['bottom'].'px!important;';
			if (isset($border['right'])) $custom_css .='border-right-width:'.$border['right'].'px!important;';
			if (isset($border['left'])) $custom_css .='border-left-width:'.$border['left'].'px!important;';
			if (isset($border['color'])) $custom_css .='border-color:'.$border['color'].'!important;';
			if (isset($border['type'])) $custom_css .='border-style:'.$border['type'].'!important;';
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-product-cnt , wg-colored-'.$rand_id.' .woo-product-cnt img{';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-moz-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-khtml-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					-webkit-border-radius:'.$border_radius_top.' '.$border_radius_right.' '.$border_radius_left.' '.$border_radius_bottom.';
					';
			}
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-product-cnt .woo-overlay-cnt {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:0  0 '.$border_radius_left.'  0;
					-moz-border-radius:0 0 '.$border_radius_left.'  0;
					-khtml-border-radius:0 0 '.$border_radius_left.' 0;
					-webkit-border-radius:0 0 '.$border_radius_left.' 0;
					';
			}
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-product-cnt .woo-banner.feature-banner {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:0  '.$border_radius_right.' 0  0;
					-moz-border-radius:0 '.$border_radius_right.' 0 0;
					-khtml-border-radius:0 '.$border_radius_right.' 0 0;
					-webkit-border-radius:0 '.$border_radius_right.' 0 0;
					';
			}
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-product-cnt .woo-banner.sale-banner {';
			if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){ 
				$custom_css .='
					border-radius:'.$border_radius_top.' 0 0  0;
					-moz-border-radius:'.$border_radius_top.' 0 0 0;
					-khtml-border-radius:'.$border_radius_top.' 0 0 0;
					-webkit-border-radius:'.$border_radius_top.' 0 0 0;
					';
			}
		$custom_css .='}
		/*COLORED SHADOW STYLES*/
		';
		if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow'])){
			$custom_css .='
				.wg-colored-'.$rand_id.' .woo-product-cnt {
					-webkit-box-shadow:'.$shadow_type.' '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
					-moz-box-shadow: '.$shadow_type.' '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
					box-shadow:'.$shadow_type.'  '.$shadow_hor.' '.$shadow_ver.' '.$shadow_blur.' '.$shadow_spread.' '.$shadow_color.';
			}';
		}
		$custom_css .= '
		/*colored FAV OPTION*/
		.wg-colored-'.$rand_id.' .woo-addfav i.pw-woo-ad-search-unfavorite{';
			if (isset($fav_style['color'])) $custom_css .='color:'.$fav_style['color'].'!important;';
		$custom_css .='}
			.wg-colored-'.$rand_id.' .woo-addfav:hover i.pw-woo-ad-search-unfavorite{';
				if (isset($fav_style['hcolor'])) $custom_css .='color:'.$fav_style['hcolor'].'!important;';
			$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-addfav i.pw-woo-ad-search-favorite{';
			if (isset($fav_style['active-color'])) $custom_css .='color:'.$fav_style['active-color'].'!important;';
		$custom_css .='}
			.wg-colored-'.$rand_id.' .woo-addfav:hover i.pw-woo-ad-search-favorite{';
				if (isset($fav_style['active-hcolor'])) $custom_css .='color:'.$fav_style['active-hcolor'].'!important;';
			$custom_css .='}
		';
		
		
		/////////LOADING BACKGROUND////////
		$custom_css.='.loading-cnt{background:'.((get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_color')=='' ? "#fff":get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_color'))).' !important;}';
		
		
	wp_add_inline_style( 'pw-pl-custom-style', $custom_css );	
}

?>