<?php
	header("Content-type: text/css; charset: UTF-8");
	$color = get_option('color');
	
	global $pw_woo_ad_main_class;
	
	//GENERAL STYLES
	$overlay_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'overlay_background_set'];
	$background_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'background_set'];
	
	$border = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'border_set'];
	$margin = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'margin_set'];
	$padding = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'padding_set'];
	
	$border_radius_top=$border_radius_right=$border_radius_bottom=$border_radius_left='';
	if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'active_border_radius'])){
		$radius = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'border_radius_set'];
		
		$border_radius_top = (isset($radius['top']))?$radius['top'].'px':'0px';
		$border_radius_bottom = (isset($radius['bottom']))?$radius['bottom'].'px':'0px';
		$border_radius_right = (isset($radius['right']))?$radius['right'].'px':'0px';
		$border_radius_left = (isset($radius['left']))?$radius['left'].'px':'0px';
		
	}
	
	$price_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'price_font_set'];
	$title_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'title_font_set'];
	$excerpt_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'excerpt_font_set'];
	$meta_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'meta_font_set'];
	$general_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'font_set'];
	$sale_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'banner_sale_font_set'];
	$feature_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'banner_featured_font_set'];
	$fav_style = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'favorite_icon_color'];
	
	$btn_option = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'set_btn_option'];
	
	$shadow_hor = $shadow_color = $shadow_opacity = $shadow_spread = $shadow_ver = $shadow_blur ='';
	if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_enable_shadow'])){
		$box_shadow_set=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'box_shadow_set'];
		
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
	
	$imported_font = $price_family = $title_family = $excerpt_family = $meta_family =$general_family =$sale_family =$feature_family =array(); 
	
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
	$i=0;$sep='|';$font_family='';
	foreach ( $imported_font as $font ){
		if ($i==0){$sep='';}
		$font_family .= $sep . $font;
		$sep='|';
		$i++;
	}
 
	$custom_css = '
		@import url(http://fonts.googleapis.com/css?family='. $font_family.');
		/*
		//////////////////////TABLE STYLES////////////////
		*/
		.wg-table-'.$rand_id.' thead tr th{
			background-color: '.$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_head_background_color'].';
			color: '.$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_head_text_color'].';
		}
		.wg-table-'.$rand_id.' tr:nth-child(even) , .wg-table-'.$rand_id.' tr:nth-child(odd){
			background-color: '.$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_background_color'].'!important;
		}
			.wg-table-'.$rand_id.' tr:nth-child(even):hover , .wg-table-'.$rand_id.' tr:nth-child(odd):hover{
				background-color: '.$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_hover_row_color'].'!important;
			}
			.wg-table-'.$rand_id.' td {';
				
				if (isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_border_color'])){
					 $custom_css .= 'border-left-color:'.$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_border_color'].'!important;
					 border-top-color:'.$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'tbl_border_color'].'!important;';
				}
			$custom_css .=
			'}
			
			
		.wg-table-'.$rand_id.' .woo-product-delprice del , .wg-table-'.$rand_id.' .woo-product-price{';
			if (isset($price_style['color'])) $custom_css .='color:'.$price_style['color'].';';
			if (isset($price_style['size'])) $custom_css .='font-size:'.$price_style['size'].'px;';
			if (isset($price_style['font-family'])) $custom_css .='font-family:"'.$price_family[0].'";';
		$custom_css .='}
		
		.wg-table-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].';';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px;';
			if (isset($title_style['font-family'])) $custom_css .='font-family:"'.$title_family[0].'";';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-product-title a:hover{';
			if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].';';
		$custom_css .='}
		
		
		.wg-table-'.$rand_id.' .woo-product-desc{';
			if (isset($excerpt_style['color'])) $custom_css .='color:'.$excerpt_style['color'].';';
			if (isset($excerpt_style['size'])) $custom_css .='font-size:'.$excerpt_style['size'].'px;';
			if (isset($excerpt_style['font-family'])) $custom_css .='font-family:"'.$excerpt_family[0].'";';
		$custom_css .='}
		
		
		.wg-table-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].';';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px;';
			if (isset($meta_style['font-family'])) $custom_css .='font-family:"'.$meta_family[0].'";';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].';';
		$custom_css .='}
		
		
		.wg-table-'.$rand_id.', .wg-table-'.$rand_id.' .wg-star-rating ,.wg-table-'.$rand_id.' .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].';';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .='font-family:"'.$general_family[0].'";';
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
			if (isset($sale_style['size'])) $custom_css .='font-size:'.$sale_style['size'].'!important;';
			if (isset($sale_style['font-family'])) $custom_css .='font-family:"'.$sale_family[0].'";';
		$custom_css .='}
		.wg-table-'.$rand_id.' .woo-banner.feature-banner{';
			if (isset($feature_style['bgcolor'])) $custom_css .='background:'.$feature_style['bgcolor'].'!important;';
			if (isset($feature_style['color'])) $custom_css .='color:'.$feature_style['color'].'!important;';
			if (isset($feature_style['size'])) $custom_css .='font-size:'.$feature_style['size'].'!important;';
			if (isset($feature_style['font-family'])) $custom_css .='font-family:"'.$feature_family[0].'";';
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
			if (isset($price_style['font-family'])) $custom_css .='font-family:"'.$price_family[0].'";';
		$custom_css .='}
		
		.wg-boxed-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px!important;';
			if (isset($title_style['font-family'])) $custom_css .='font-family:"'.$title_family[0].'";';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-banner.sale-banner ,.wg-boxed-'.$rand_id.' .woo-banner.feature-banner ,.wg-boxed-'.$rand_id.' .woo-btns > div , .wg-boxed-'.$rand_id.' .woo-btns > div a {';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important; border-color:'.$title_style['color'].'!important;';
		$custom_css .='}
			
			.wg-boxed-'.$rand_id.' .woo-btns > div a:hover i {';
				if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
			$custom_css .='}
		
		.wg-boxed-'.$rand_id.' .woo-product-title a:hover{';
			if (isset($title_style['hcolor'])) $custom_css .='color:'.$title_style['hcolor'].'!important;';
		$custom_css .='}
		
		
		.wg-boxed-'.$rand_id.' .woo-product-desc{';
			if (isset($excerpt_style['color'])) $custom_css .='color:'.$excerpt_style['color'].'!important;';
			if (isset($excerpt_style['size'])) $custom_css .='font-size:'.$excerpt_style['size'].'px!important;';
			if (isset($excerpt_style['font-family'])) $custom_css .='font-family:"'.$excerpt_family[0].'";';
		$custom_css .='}
		
		
		.wg-boxed-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px!important;';
			if (isset($meta_style['font-family'])) $custom_css .='font-family:"'.$meta_family[0].'";';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].'!important;';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' , .wg-boxed-'.$rand_id.' .wg-star-rating ,.wg-boxed-'.$rand_id.' .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].'!important;';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .='font-family:"'.$general_family[0].'";';
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
			if (isset($sale_style['size'])) $custom_css .='font-size:'.$sale_style['size'].'!important;';
			if (isset($sale_style['font-family'])) $custom_css .='font-family:"'.$sale_family[0].'";';
		$custom_css .='}
		.wg-boxed-'.$rand_id.' .woo-banner.feature-banner{';
			if (isset($feature_style['bgcolor'])) $custom_css .='background:'.$feature_style['bgcolor'].'!important;';
			if (isset($feature_style['color'])) $custom_css .='color:'.$feature_style['color'].'!important;';
			if (isset($feature_style['size'])) $custom_css .='font-size:'.$feature_style['size'].'!important;';
			if (isset($feature_style['font-family'])) $custom_css .='font-family:"'.$feature_family[0].'";';
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
			if (isset($price_style['font-family'])) $custom_css .='font-family:"'.$price_family[0].'";';
		$custom_css .='}
		
		.wg-grid-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px!important;';
			if (isset($title_style['font-family'])) $custom_css .='font-family:"'.$title_family[0].'";';
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
			if (isset($excerpt_style['font-family'])) $custom_css .='font-family:"'.$excerpt_family[0].'";';
		$custom_css .='}
		
		
		.wg-grid-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px!important;';
			if (isset($meta_style['font-family'])) $custom_css .='font-family:"'.$meta_family[0].'";';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].'!important;';
		$custom_css .='}
		.wg-grid-'.$rand_id.' , .wg-grid-'.$rand_id.' .wg-star-rating ,.wg-grid-'.$rand_id.' .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].'!important;';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .='font-family:"'.$general_family[0].'";';
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
			if (isset($sale_style['size'])) $custom_css .='font-size:'.$sale_style['size'].'!important;';
			if (isset($sale_style['font-family'])) $custom_css .='font-family:"'.$sale_family[0].'";';
		$custom_css .='}
		.wg-grid-'.$rand_id.' .woo-banner.feature-banner{';
			if (isset($feature_style['bgcolor'])) $custom_css .='background:'.$feature_style['bgcolor'].'!important;';
			if (isset($feature_style['color'])) $custom_css .='color:'.$feature_style['color'].'!important;';
			if (isset($feature_style['size'])) $custom_css .='font-size:'.$feature_style['size'].'!important;';
			if (isset($feature_style['font-family'])) $custom_css .='font-family:"'.$feature_family[0].'";';
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
			if (isset($price_style['font-family'])) $custom_css .='font-family:"'.$price_family[0].'";';
		$custom_css .='}
		
		.wg-list-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px!important;';
			if (isset($title_style['font-family'])) $custom_css .='font-family:"'.$title_family[0].'";';
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
			if (isset($excerpt_style['font-family'])) $custom_css .='font-family:"'.$excerpt_family[0].'";';
		$custom_css .='}
		
		
		.wg-list-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px!important;';
			if (isset($meta_style['font-family'])) $custom_css .='font-family:"'.$meta_family[0].'";';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].'!important;';
		$custom_css .='}
		.wg-list-'.$rand_id.'  , .wg-list-'.$rand_id.' .wg-star-rating ,.wg-list-'.$rand_id.' .wg-woocommerce-review-link  {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].'!important;';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .='font-family:"'.$general_family[0].'";';
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
			if (isset($sale_style['size'])) $custom_css .='font-size:'.$sale_style['size'].'!important;';
			if (isset($sale_style['font-family'])) $custom_css .='font-family:"'.$sale_family[0].'";';
		$custom_css .='}
		.wg-list-'.$rand_id.' .woo-banner.feature-banner{';
			if (isset($feature_style['bgcolor'])) $custom_css .='background:'.$feature_style['bgcolor'].'!important;';
			if (isset($feature_style['color'])) $custom_css .='color:'.$feature_style['color'].'!important;';
			if (isset($feature_style['size'])) $custom_css .='font-size:'.$feature_style['size'].'!important;';
			if (isset($feature_style['font-family'])) $custom_css .='font-family:"'.$feature_family[0].'";';
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
			if (isset($price_style['font-family'])) $custom_css .='font-family:"'.$price_family[0].'";';
		$custom_css .='}
		
		.wg-colored-'.$rand_id.' .woo-product-title a{';
			if (isset($title_style['color'])) $custom_css .='color:'.$title_style['color'].'!important;';
			if (isset($title_style['size'])) $custom_css .='font-size:'.$title_style['size'].'px!important;';
			if (isset($title_style['font-family'])) $custom_css .='font-family:"'.$title_family[0].'";';
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
			if (isset($excerpt_style['font-family'])) $custom_css .='font-family:"'.$excerpt_family[0].'";';
		$custom_css .='}
		
		
		.wg-colored-'.$rand_id.' .woo-product-category a{';
			if (isset($meta_style['color'])) $custom_css .='color:'.$meta_style['color'].'!important;';
			if (isset($meta_style['size'])) $custom_css .='font-size:'.$meta_style['size'].'px!important;';
			if (isset($meta_style['font-family'])) $custom_css .='font-family:"'.$meta_family[0].'";';
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-product-category a:hover{';
			if (isset($meta_style['hcolor'])) $custom_css .='color:'.$meta_style['hcolor'].'!important;';
		$custom_css .='}
		.wg-colored-'.$rand_id.', .wg-colored-'.$rand_id.' .wg-star-rating ,.wg-colored-'.$rand_id.' .wg-woocommerce-review-link   {';
			if (isset($general_style['color'])) $custom_css .='color:'.$general_style['color'].'!important;';
			if (isset($general_style['size'])) $custom_css .='font-size:'.$general_style['size'].'px!important;';
			if (isset($general_style['font-family'])) $custom_css .='font-family:"'.$general_family[0].'";';
		$custom_css .='}
		
		.wg-colored-'.$rand_id.' .woo-banner.sale-banner   {';
			if (isset($sale_style['font-family'])) $custom_css .='font-family:"'.$sale_family[0].'";';
		$custom_css .='}
		.wg-colored-'.$rand_id.' .woo-banner.feature-banner   {';
			if (isset($feature_style['font-family'])) $custom_css .='font-family:"'.$feature_family[0].'";';
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
	echo $custom_css;	
	//wp_add_inline_style( 'pw-pl-custom-style', $custom_css );	

?>