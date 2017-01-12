<?php
	if(!class_exists('PW_SEARCH_FRAMEWORK'))
	{
		class PW_SEARCH_FRAMEWORK
		{		
			public $search_arguments=array();
			public $search_enable,$search_fields,$search_position,$search_order='';
			public $query_taxonomies=array();
			public $taxonomy_filter=array();
			/*public $switch_fields=array();*/
			
			function __construct()
			{  

			}

			public function make_attr_image_filter()
			{
				$attribute_taxonomies = wc_get_attribute_taxonomies();
				$curr_atts = array();
				if ( !empty( $attribute_taxonomies ) && !is_wp_error( $attribute_taxonomies ) ){
					foreach ( $attribute_taxonomies as $term ) {
						echo $term->attribute_name;
						$attr='pa_' . $term->attribute_name;
						$curr_attributes = get_terms( $attr );
						foreach ( $curr_attributes as $attribute ) {
							$curr_attr_element = wp_get_attachment_image( get_woocommerce_term_meta($attribute->term_id, 'thumbnail_id_attr', true), 'shop_thumbnail' );
							$curr_attr_element .= $attribute->name;
							echo $curr_attr_element;
						}
					}
				}
			}

			public function make_category_drop_down($_ARGS)
			{
				$meta=$_ARGS['meta'];
				
				$args = $_ARGS['args'];
				$categories = get_categories($args); 
				$display_type=$_ARGS['display_type'];
				
				$option='';
				if(isset($this->query_taxonomies['pw_'.$args['taxonomy']]))
				{
					if(sizeof($this->query_taxonomies['pw_'.$args['taxonomy']])>1)
					{
						foreach ($categories as $category) {
							if(!in_array($category->cat_ID,$this->query_taxonomies['pw_'.$args['taxonomy']]))
								continue;
							
							$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id', true), 'shop_thumbnail' );
							$attribute_img=$attribute_img[0];
							if($attribute_img=='')
							{
								$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id_attr', true), 'shop_thumbnail' );
							
								$attribute_img=$attribute_img[0];		
							}
							
							$seleted='';
							if(is_array($meta) && in_array($category->cat_ID,$meta))
								$seleted="SELECTED";
							
							if($display_type=='pw_tax_display_dropdown_lbl')
								$option .= '<option value="'.$category->cat_ID.'" '.$seleted.'>';
							else
								$option .= '<option data-img="'.$attribute_img.'" value="'.$category->cat_ID.'" '.$seleted.'>';
							
							$option .= $category->cat_name;
							$option .= ' ('.$category->category_count.')';
							$option .= '</option>';
						}
					}
				}else
				{
					foreach ($categories as $category) {
						$seleted='';
						if(is_array($meta) && in_array($category->cat_ID,$meta))
							$seleted="SELECTED";
						
						$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id', true), 'shop_thumbnail' );
						$attribute_img=$attribute_img[0];
						if($attribute_img=='')
						{
							$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id_attr', true), 'shop_thumbnail' );
						
							$attribute_img=$attribute_img[0];		
						}
							
						if($display_type=='pw_tax_display_dropdown_lbl')
							$option .= '<option value="'.$category->cat_ID.'" '.$seleted.'>';
						else
							$option .= '<option data-img="'.$attribute_img.'" value="'.$category->cat_ID.'" '.$seleted.'>';
						$option .= $category->cat_name;
						$option .= ' ('.$category->category_count.')';
						$option .= '</option>';
					}
				}
				return $option;
			}
			
			
			public function make_attribute_drop_down($_ARGS)
			{
				$meta=$_ARGS['meta'];
				
				$args = $_ARGS['args'];
				$categories = get_categories($args); 
				
				
				$option='';
				if(isset($this->query_taxonomies['pw_'.$args['taxonomy']]))
				{
					if(sizeof($this->query_taxonomies['pw_'.$args['taxonomy']])>1)
					{
						foreach ($categories as $category) {
							if(!in_array($category->cat_ID,$this->query_taxonomies['pw_'.$args['taxonomy']]))
								continue;
							
							$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id_attr', true), 'shop_thumbnail' );
							$attribute_img=$attribute_img[0];	
								
							$seleted='';
							if(is_array($meta) && in_array($category->cat_ID,$meta))
								$seleted="SELECTED";
							$option .= '<option data-img="'.$attribute_img.'" value="'.$category->cat_ID.'" '.$seleted.'>';
							$option .= $category->cat_name;
							$option .= ' ('.$category->category_count.')';
							$option .= '</option>';
						}
					}
				}else
				{
					foreach ($categories as $category) {
						
						$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id_attr', true), 'shop_thumbnail' );
						$attribute_img=$attribute_img[0];
						
						$seleted='';
						if(is_array($meta) && in_array($category->cat_ID,$meta))
							$seleted="SELECTED";
						$option .= '<option data-img="'.$attribute_img.'" value="'.$category->cat_ID.'" '.$seleted.'>';
						$option .= $category->cat_name;
						$option .= ' ('.$category->category_count.')';
						$option .= '</option>';
					}
				}
				return $option;
			}
			
			
			public function make_category_list($_ARGS)
			{	
				$args = $_ARGS['args'];
				$categories = get_categories($args); 
				
				$meta=$_ARGS['meta'];
				$field_name=$args['taxonomy'];
				$display_type=$_ARGS['display_type'];
				$additional_calss="pw_woo_ad_attr_checkbox ".$field_name.$_ARGS['rand_id'];
				
				
				$output='';
				$none_item='';
				if(isset($this->query_taxonomies['pw_'.$args['taxonomy']]))
				{
					if(sizeof($this->query_taxonomies['pw_'.$args['taxonomy']])>1)
					{
						foreach ($categories as $category) {
							if(!in_array($category->cat_ID,$this->query_taxonomies['pw_'.$args['taxonomy']]))
								continue;
							
							$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id', true), 'shop_thumbnail' );
							$attribute_img=$attribute_img[0];
							if($attribute_img=='')
							{
								$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id_attr', true), 'shop_thumbnail' );
							
								$attribute_img=$attribute_img[0];		
							}
							$cat_img=$attribute_img;
							
							$seleted='';
							$active_class='';
							if(is_array($meta) && in_array($category->cat_ID,$meta)){
								$seleted="CHECKED";
								$active_class='woo-active-check';
							}
							
							switch($display_type){
								case "pw_tax_display_inline_lbl":
								{
									$none_item='
									<label class="woo-checkbox-lbl none-value">
										<span class="woo-lbl">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
									</label>
									';
									
									$output.='
									<label class="woo-checkbox-lbl '.$active_class.'">
										<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
										<span class="woo-lbl">'.$category->cat_name.'</span>
									</label>
									';
								}
								break;
								
								case "pw_tax_display_list_lbl":
								{
									$none_item='
									<label class="woo-checkbox-lbl  woo-search-items  none-value">
										<span class="woo-lbl">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
									</label>
									';
									
									$output.='
									<label class="woo-checkbox-lbl woo-search-items '.$active_class.'">
										<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
										<span class="woo-lbl">'.$category->cat_name.'</span>
									</label>
									';
								}
								break;
								
								case "pw_tax_display_inline_img":
								{
									$none_item='
									<label class="woo-checkbox-lbl woo-checkbox-imaged  none-value">
										<img class="woo-check-img" src="'.__PW_WOO_AD_SEARCH_URL__.'/assets/images/pw-transparent.gif" width="20" height="20" title="'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" />
									</label>
									';
									
									$output.='
									<label class="woo-checkbox-lbl woo-checkbox-imaged '.$active_class.'">
										<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
										<img class="woo-check-img" src="'.$cat_img.'" width="20" height="20" title="'.$category->cat_name.'" />
									</label>	
									';
								}
								break;
								
								case "pw_tax_display_list_lbl_img":
								{
									$none_item='
									<label class="woo-checkbox-lbl  woo-checkbox-imaged  none-value">
										<img class="woo-check-img" src="'.__PW_WOO_AD_SEARCH_URL__.'/assets/images/pw-transparent.gif" width="20" height="20"  title="'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'"/>
										<span class="woo-lbl">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
									</label>
									';
									
									$output.='
									<label class="woo-checkbox-lbl woo-checkbox-imaged '.$active_class.'">
										<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
										<img class="woo-check-img" src="'.$cat_img.'" width="20" height="20" title="'.$category->cat_name.'" />
										<span class="woo-lbl">'.$category->cat_name.'</span>
									</label>
									';
								}
								break;
							}
						}
					}
				}else
				{	
					foreach ($categories as $category) {
						
						$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id', true), 'shop_thumbnail' );
						$attribute_img=$attribute_img[0];
						if($attribute_img=='')
						{
							$attribute_img= wp_get_attachment_image_src( get_woocommerce_term_meta($category->cat_ID, 'thumbnail_id_attr', true), 'shop_thumbnail' );
						
							$attribute_img=$attribute_img[0];		
						}
						$cat_img=$attribute_img;
						
						$seleted='';
						$active_class='';
						if(is_array($meta) && in_array($category->cat_ID,$meta)){
							$seleted="CHECKED";
							$active_class='woo-active-check';
						}
						
						switch($display_type){
								case "pw_tax_display_inline_lbl":
								{
									$none_item='
									<label class="woo-checkbox-lbl none-value">
										<span class="woo-lbl">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
									</label>
									';
									
									$output.='
									<label class="woo-checkbox-lbl '.$active_class.'">
										<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
										<span class="woo-lbl">'.$category->cat_name.'</span>
									</label>
									';
								}
								break;
								
								case "pw_tax_display_list_lbl":
								{
									$none_item='
									<label class="woo-checkbox-lbl  woo-search-items  none-value">
										<span class="woo-lbl">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
									</label>
									';
									
									$output.='
									<label class="woo-checkbox-lbl woo-search-items '.$active_class.'">
										<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
										<span class="woo-lbl">'.$category->cat_name.'</span>
									</label>
									';
								}
								break;
								
								case "pw_tax_display_inline_img":
								{
									$none_item='
									<label class="woo-checkbox-lbl woo-checkbox-imaged  none-value">
										<img class="woo-check-img" src="'.__PW_WOO_AD_SEARCH_URL__.'/assets/images/pw-transparent.gif" width="20" height="20" title="'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" />
									</label>
									';
									
									$output.='
									<label class="woo-checkbox-lbl woo-checkbox-imaged '.$active_class.'">
										<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
										<img class="woo-check-img" src="'.$cat_img.'" width="20" height="20" title="'.$category->cat_name.'" />
									</label>	
									';
								}
								break;
								
								case "pw_tax_display_list_lbl_img":
								{
									$none_item='
									<label class="woo-checkbox-lbl  woo-checkbox-imaged  none-value">
										<img class="woo-check-img" src="'.__PW_WOO_AD_SEARCH_URL__.'/assets/images/pw-transparent.gif" width="20" height="20"  title="'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'"/>
										<span class="woo-lbl">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
									</label>
									';
									
									$output.='
									<label class="woo-checkbox-lbl woo-checkbox-imaged '.$active_class.'">
										<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
										<img class="woo-check-img" src="'.$cat_img.'" width="20" height="20" title="'.$category->cat_name.'" />
										<span class="woo-lbl">'.$category->cat_name.'</span>
									</label>
									';
								}
								break;
							}
					}
				}
				
				if($output!='')
				{
					$output=$none_item.$output;
				}
				
				return $output;
			}
			
			public function make_category_filter($_ARGS)
			{
				$args = $_ARGS['args'];
				$categories = get_categories($args); 
				
				$meta=$_ARGS['meta'];
				$field_name=$args['taxonomy'];
				$additional_calss="pw_woo_ad_attr_filter ".$field_name.$_ARGS['rand_id'];
				
				$option='';
				if(isset($this->query_taxonomies['pw_'.$args['taxonomy']]))
				{
					if(sizeof($this->query_taxonomies['pw_'.$args['taxonomy']])>1)
					{
						foreach ($categories as $category) {
							if(!in_array($category->cat_ID,$this->query_taxonomies['pw_'.$args['taxonomy']]))
								continue;
							$active_class='';
							$seleted='';
							if(is_array($meta) && in_array($category->cat_ID,$meta))
							{
								$seleted='checked';
								$active_class="woo-active-check";
							}
								
							$option .= '
							<label class="woo-checkbox-lbl '.$active_class.'">
								<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
								<span class="woo-lbl">'.$category->cat_name.'</span>
							</label>';
						}
					}
				}else
				{
					foreach ($categories as $category) {
						
						$active_class='';
						$seleted='';
						if(is_array($meta) && in_array($category->cat_ID,$meta))
						{
							$seleted='checked';
							$active_class="woo-active-check";
						}
							
						$option .= '
						<label class="woo-checkbox-lbl '.$active_class.'">
							<input type="checkbox" '.$seleted.' name="'.$field_name.'[]" value="'.$category->cat_ID.'" class="'.$additional_calss.'"/>
							<span class="woo-lbl">'.$category->cat_name.'</span>
						</label>';
					}
				}
				
				if($option!='')
				{
					$option='
					<label class="woo-checkbox-lbl none-value" data-value="">
	                    <span class="woo-lbl">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
					</label>'.$option;
				}
				return $option;
			}
			
			public function display_price($woo_currency_pos,$woo_currency_symbol,$value){
				if($woo_currency_pos=='left_space'){
					return $woo_currency_symbol.' '.number_format($value);
				}else if($woo_currency_pos=='left'){
					return $woo_currency_symbol.number_format($value);
				}else if($woo_currency_pos=='right_space'){
					return number_format($value).' '.$woo_currency_symbol;
				}else if($woo_currency_pos=='right'){
					return number_format($value).$woo_currency_symbol;
				}
			}
			
			public function build_search_form_html($fields)
			{
				global $pw_woo_ad_main_class;
				global $_chosen_attributes, $wpdb, $wp;
				extract($fields);
			
				//FETCH ALL SHORTCODE DETAILS
				$pw_woo_ad_main_class->fetch_custom_fields($pw_sf_shortcode_id);
			
				///////////////GRID-Search OPTION//////////////////
				$search_sticky_margin_top=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_margin')=='' ? '400':get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_margin'));
				if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_margin']))
				{
					$search_sticky_margin_top=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_margin'];
				}
	
				$search_sticky_height=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_height')=='' ? '600':get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_height'));
				if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_height']))
				{
					$search_sticky_height=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_height'];
				}
				
				$pw_sf_enable_reset_btn=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_reset_btn','custom_field','');
				
				$category_taxonomy_style=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields_tax_style','custom_field','dropdown_style');
				
				$search_fields_tax_style_preset=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_fields_tax_style_preset','custom_field','preset_1');
				
				$additional_calss_preset='woo-searchcombo-'.$search_fields_tax_style_preset;
				if($category_taxonomy_style=='filter_style')
					$additional_calss_preset='woo-search-filter-'.$search_fields_tax_style_preset;
				
				
				$main_price_min = floor( $wpdb->get_var(
					$wpdb->prepare('
						SELECT min(meta_value + 0)
						FROM %1$s
						LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
						WHERE ( meta_key = \'%3$s\' OR meta_key = \'%4$s\' )
						AND meta_value != ""
					', $wpdb->posts, $wpdb->postmeta, '_price', '_min_variation_price' )
				) );

				$main_price_max = ceil( $wpdb->get_var(
					$wpdb->prepare('
						SELECT max(meta_value + 0)
						FROM %1$s
						LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
						WHERE meta_key = \'%3$s\'
					', $wpdb->posts, $wpdb->postmeta, '_price' )
				) );
				
				
				$main_price_from_option=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'main_price_from')=='' ? $main_price_min:get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'main_price_from'));
				
				$main_price_to_option=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'main_price_to')=='' ? $main_price_max:get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'main_price_to'));
				
			
				$price_step_option=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'price_step')=='' ? '1':get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'price_step'));
				
				$pw_sf_show_filters=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_filter','custom_field','off');
				$pw_sf_show_orders=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_show_order','custom_field','off');
				
				$search_form_header_title=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_form_header_title')=='' ? __('Advanced Search',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_form_header_title'));
				
				
				
				$search_sticky_icon='<i class="fa fa-search"></i>';
				if(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_icon_type')!='')
				{
					$icon_type=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_icon_type');
					
					if($icon_type=='fontawesome'){
					
						$search_sticky_icon='<i class="fa '.get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_font_icon').'" ></i>';
					}else if($icon_type=='upload'){
						$icon_value=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_upload_icon');
						
						$search_sticky_icon=wp_get_attachment_image( $icon_value , array(50,50),false,array("style"=>"margin:5px"));
					}
				}
				
				if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_icon']))
				{
					$search_sticky_icon=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_sticky_icon'];
					$search_sticky_icon='<i class="fa '.$search_sticky_icon.'"></i>';
				}
				//////////////////END STICKY OPTION//////////
				
				
				
				
				
				$rand_id=$pw_sf_rand_id;
				$more_optionns_search='';
				$query_posts_per_page=10;
				$query_post_type='properties';
				$query_meta_key='';
				$query_orderby='date';
				$query_order='ASC';
				$this->query_taxonomies=array();
				
				$more_optionns_search='';
				
				$combo_input = $title_input =  $sale_unput = $regular_input = $status_input = $order_input = $switch_input =$attribute_items= '';
				$form_output='';
				$form_action='';
				if(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_page')!=''){
					$form_action=get_permalink(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_page'));
				}
				
				
				//APPLY BUILD QUERY TAX/Cat Filter item FOR GRID AND SEARCH_with_buildquery
				
				$include_tax_build_query='';
				$exclude_tax_build_query='';
				
				if($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type']!='search'){
					$pw_query=$this->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'build_query_taxonomy','custom_field','');
					if($build_query_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'fetch_type']=='build_query')
					{
						if(isset($pw_query['taxonomy_checkbox'])){				

							$taxonomies=$pw_query['taxonomy_checkbox'];
							foreach($taxonomies as $taxonomy){
								if(isset($pw_query['in_'.$taxonomy]))
								{
									$taxonomy_value=$pw_query['in_'.$taxonomy];
									$include_tax_build_query[$taxonomy]=$taxonomy_value;
								}
								
								if(isset($pw_query['ex_'.$taxonomy]))
								{
									$taxonomy_value=$pw_query['ex_'.$taxonomy];
									$exclude_tax_build_query[$taxonomy]=$taxonomy_value;
								}
							}
						}
					}
				}
				
				
				
				if($pw_sf_show_filters=='on' && !isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'])){
					if(is_array($pw_sf_taxonomies) && sizeof($pw_sf_taxonomies)>0)
					{
						//FOR EXCLUDE OR INCLUDE TAX/Cat Term in taxonomy filters
						
						$this->taxonomy_filter=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_taxonomy'];
						
						$attribute_taxonomies = wc_get_attribute_taxonomies();
						$attribute_taxonomies_name_lbl=array();
						foreach($attribute_taxonomies as $attributes){
							
							$attr_label = ! empty( $attributes->attribute_label ) ? $attributes->attribute_label : $attributes->attribute_name;
							
							$attribute_taxonomies_name_lbl['pa_' .$attributes->attribute_name]['name']='pa_' .$attributes->attribute_name;
							$attribute_taxonomies_name_lbl['pa_' .$attributes->attribute_name]['lbl']=$attr_label;
						}
						
						//print_r($attribute_taxonomies_name_lbl);
						
						$pw_sf_taxonomies=array_filter($pw_sf_taxonomies);
						foreach($pw_sf_taxonomies as $pw_search_taxonomy){
							
							if($pw_search_taxonomy==$pw_sf_taxonomy)
							{
								continue;
							}
														
							//FOR EXCLUDE OR INCLUDE TAX/Cat Term in taxonomy filters
							$include_tax=(isset($include_tax_build_query[$pw_search_taxonomy]) ? $include_tax_build_query[$pw_search_taxonomy]:'');
							$exclude_tax=(isset($exclude_tax_build_query[$pw_search_taxonomy]) ? $exclude_tax_build_query[$pw_search_taxonomy]:'');
											
							if(isset($this->taxonomy_filter['in_'.$pw_search_taxonomy]))
							{
								$include_tax=$this->taxonomy_filter['in_'.$pw_search_taxonomy];
							}
								
							if(isset($this->taxonomy_filter['ex_'.$pw_search_taxonomy]))
							{
								$exclude_tax=$this->taxonomy_filter['ex_'.$pw_search_taxonomy];	
							}
						
						
							//$attribute_taxonomies = wc_get_attribute_taxonomies();
							
							
							if($category_taxonomy_style=='dropdown_style'){
								
								$pw_sf_attr_display_type=(isset($this->taxonomy_filter['taxonomy_display_type_'.$pw_search_taxonomy]) ? $this->taxonomy_filter['taxonomy_display_type_'.$pw_search_taxonomy][0] : "pw_tax_display_dropdown_lbl");
								
								if($pw_sf_attr_display_type=='')
								{
									$pw_sf_attr_display_type='pw_tax_display_dropdown_lbl';
								}
						
								$meta=(isset($_POST[$pw_search_taxonomy]) ? $_POST[$pw_search_taxonomy]:'');
								$args = array(
									'meta'               		  => $meta,
									'display_type'                => $pw_sf_attr_display_type,
									'rand_id'                	  => $rand_id,
									'args'					  => array(
												'orderby'       => 'name',
												'order'         => 'ASC',
												'hide_empty'    => 1,
												'hierarchical'  => 1,
												'include'       => $include_tax,
												'exclude'       => $exclude_tax,
												'child_of'      => 0,
												'number'        => '',
												'taxonomy'      => $pw_search_taxonomy,
												'pad_counts'    => false 
										)
								); 
								
								
								switch($pw_sf_attr_display_type){
									case "pw_tax_display_dropdown_lbl_img":
									{
										if($this->make_category_drop_down($args)!='')
										{
											$this_taxonomy=get_taxonomy($pw_search_taxonomy);	
											$lbl_tax=$this_taxonomy->label;
											
											$combo_input.= '
											<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'3').' woo-col-sm-12">
												<div class="input-group input-group-sm '.$additional_calss_preset.' ">
													<select name="'.$pw_search_taxonomy.'[]" id="'.$pw_search_taxonomy.$rand_id.'" class="search-selectbox '.$pw_search_taxonomy.$rand_id.' form-control multiselect multiselect-icon" multiple="multiple" data-combotitle="'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" data-searchfied="'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
															'.$this->make_category_drop_down($args).'
													</select>
												</div>
											</div>';
										}
									}
									break;
									
									case "pw_tax_display_dropdown_lbl":
									{
										if($this->make_category_drop_down($args)!='')
										{
											$this_taxonomy=get_taxonomy($pw_search_taxonomy);	
											$lbl_tax=$this_taxonomy->label;
											
											$combo_input.= '
											<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'3').' woo-col-sm-12">
												<div class="input-group input-group-sm '.$additional_calss_preset.' ">
													<select name="'.$pw_search_taxonomy.'[]" id="'.$pw_search_taxonomy.$rand_id.'" class="search-selectbox '.$pw_search_taxonomy.$rand_id.' form-control multiselect multiselect" multiple="multiple" data-combotitle="'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" data-searchfied="'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
															'.$this->make_category_drop_down($args).'
													</select>
												</div>
											</div>';
										}
									}
									break;
								}
							}elseif($category_taxonomy_style=='list_style'){
								
								$pw_sf_attr_display_type=(isset($this->taxonomy_filter['taxonomy_display_type_'.$pw_search_taxonomy])  ? $this->taxonomy_filter['taxonomy_display_type_'.$pw_search_taxonomy][0] : "pw_tax_display_inline_lbl");
							
								if($pw_sf_attr_display_type=='')
								{
									$pw_sf_attr_display_type='pw_tax_display_inline_lbl';
								}
						
								$meta=(isset($_POST[$pw_search_taxonomy]) ? $_POST[$pw_search_taxonomy]:'');
								$args = array(
									'meta'               		  => $meta,
									'display_type'                => $pw_sf_attr_display_type,
									'rand_id'                => $rand_id,
									'args'					  => array(
												'orderby'       => 'name',
												'order'         => 'ASC',
												'hide_empty'    => 1,
												'hierarchical'  => 1,
												'include'       => $include_tax,
												'exclude'       => $exclude_tax,
												'child_of'      => 0,
												'number'        => '',
												'taxonomy'      => $pw_search_taxonomy,
												'pad_counts'    => false 
										)
								); 
								
								switch($pw_sf_attr_display_type){
									case "pw_tax_display_inline_lbl":
									{
										if($this->make_category_list($args)!='')
										{
											$this_taxonomy=get_taxonomy($pw_search_taxonomy);	
											$lbl_tax=$this_taxonomy->label;
											
											$combo_input.= '
											<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
												<div class="woo-searchfield-title" >'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
													<div class="woo-search-items item-style-2" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
														'.$this->make_category_list($args).'
													</div>										
											</div>';
										}
									}
									break;
									
									case "pw_tax_display_list_lbl":
									{
										if($this->make_category_list($args)!='')
										{
											$this_taxonomy=get_taxonomy($pw_search_taxonomy);	
											$lbl_tax=$this_taxonomy->label;
											
											$combo_input.= '
											<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
												<div class="woo-searchfield-title" >'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
													<div class="woo-search-items item-style-1" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
														'.$this->make_category_list($args).'
													</div>										
											</div>';
										}
									}
									break;
									
									case "pw_tax_display_inline_img":
									{
										if($this->make_category_list($args)!='')
										{
											$this_taxonomy=get_taxonomy($pw_search_taxonomy);	
											$lbl_tax=$this_taxonomy->label;
											
											$combo_input.= '
											<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
												<div class="woo-searchfield-title" >'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
													<div class="woo-search-items item-style-2" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
														'.$this->make_category_list($args).'
													</div>										
											</div>';
										}
									}
									break;
									
									case "pw_tax_display_list_lbl_img":
									{
										if($this->make_category_list($args)!='')
										{
											$this_taxonomy=get_taxonomy($pw_search_taxonomy);	
											$lbl_tax=$this_taxonomy->label;
											
											$combo_input.= '
											<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
												<div class="woo-searchfield-title" >'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
													<div class="woo-search-items item-style-1" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
														'.$this->make_category_list($args).'
													</div>										
											</div>';
										}
									}
									break;
									
									default:
									{
										if($this->make_category_list($args)!='')
										{
											$this_taxonomy=get_taxonomy($pw_search_taxonomy);	
											$lbl_tax=$this_taxonomy->label;
											
											$combo_input.= '
											<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
												<div class="woo-searchfield-title" >'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
													<div class="woo-search-items item-style-2" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
														'.$this->make_category_list($args).'
													</div>										
											</div>';
										}
									}
								}
								
							}elseif($category_taxonomy_style=='filter_style'){
								
								$meta=(isset($_POST[$pw_search_taxonomy]) ? $_POST[$pw_search_taxonomy]:'');
								$args = array(
									'meta'               		  => $meta,
									'display_type'                => '',
									'rand_id'                	  => $rand_id,
									'args'					  => array(
												'orderby'       => 'name',
												'order'         => 'ASC',
												'hide_empty'    => 1,
												'hierarchical'  => 1,
												'include'       => $include_tax,
												'exclude'       => $exclude_tax,
												'child_of'      => 0,
												'number'        => '',
												'taxonomy'      => $pw_search_taxonomy,
												'pad_counts'    => false 
										)
								); 
								
								if($this->make_category_filter($args)!='')
								{
									$this_taxonomy=get_taxonomy($pw_search_taxonomy);	
									$lbl_tax=$this_taxonomy->label;
									
									$combo_input.= '
									<div class="woo-col-md-12  woo-searchfilter-cnt">
										<div class="woo-searchfilter-title" >'.__($lbl_tax,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
											<div class="woo-search-filter-items '.$additional_calss_preset.'" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
												'.$this->make_category_filter($args).'
											</div>										
									</div>';
								}
							}
						}
						//$combo_input.=$attribute_items;
					}
				
					if(is_array($pw_sf_fields) && sizeof($pw_sf_fields)>0)
					{
						$pw_sf_fields=array_filter($pw_sf_fields);
						$more_optionns_search='';
						
						foreach($pw_sf_fields as $field){
	
							$meta=(isset($_POST[$field]) ? $_POST[$field]:'');
							switch ($field)
							{
								case "main_price_range" :
								{
									$price_min=$main_price_from_option;
									$price_max=$main_price_to_option;
									
									$price_from=(isset($_POST['search_from_main_price_range']) ? $_POST['search_from_main_price_range']:$price_min);
									$price_to=(isset($_POST['search_to_main_price_range']) ? $_POST['search_to_main_price_range']:$price_max);
									
									$price_from_lbl=number_format($price_from);
									$price_to_lbl=number_format($price_to);
									$woo_currency_symbol=get_woocommerce_currency_symbol();
									$woo_currency_pos=get_option( 'woocommerce_currency_pos' );
									
									$price_from_lbl=$this->display_price($woo_currency_pos,$woo_currency_symbol,$price_from);
									$price_to_lbl=$this->display_price($woo_currency_pos,$woo_currency_symbol,$price_to);
									
									if($category_taxonomy_style=='dropdown_style'){
										$form_output.= '
										<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'6').'  woo-col-sm-12">
											<div class="input-group input-group-sm '.$additional_calss_preset.' price-wrapper">
												  <div class="price-rang-num">
													  <label for="amount">'.__('Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : </label>
													  <label id="amount_main_price'.$rand_id.'" >'.$price_from_lbl.' - '.$price_to_lbl.'</label>
												  </div>
												  <div class="range-bar">
													<div id="main_price-range'.$rand_id.'" data-min-num="'.$price_min.'" data-max-num="'.$price_max.'" ></div>
												 </div>
												  <input type="hidden" name="search_from_main_price_range" id="from_main_price_range'.$rand_id.'"data-slider-element="main_price-range'.$rand_id.'"  class="input_price_range title-input from_main_price_range'.$rand_id.'"  value="'.$price_from.'" data-searchfied="'.__('Price Range (From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" title="'.__('Price Range (From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" >
												  <input type="hidden" name="search_to_main_price_range" id="to_main_price_range'.$rand_id.'" data-slider-element="main_price-range'.$rand_id.'" class="input_price_range title-input to_main_price_range'.$rand_id.'" value="'.$price_to.'" data-searchfied="'.__('Price Range (To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" title="'.__('Price Range (To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
												 
											</div>
										</div>';
											
										$form_output.= '
										<script type="text/javascript"> 
											jQuery(document).ready(function(){
												jQuery( "#main_price-range'.$rand_id.'" ).slider({
													range: true,
													min: parseInt(jQuery( "#main_price-range'.$rand_id.'").attr("data-min-num")),
													max: parseInt(jQuery( "#main_price-range'.$rand_id.'").attr("data-max-num")),
													step: '.$price_step_option.',
													values: [ (jQuery( "#from_main_price_range'.$rand_id.'" ).val()=="" ? parseInt(jQuery( "#main_price-range'.$rand_id.'").attr("data-min-num")):jQuery( "#from_main_price_range'.$rand_id.'" ).val() ) ,(jQuery( "#to_main_price_range'.$rand_id.'" ).val()=="" ? parseInt(jQuery( "#main_price-range'.$rand_id.'").attr("data-max-num")):jQuery( "#to_main_price_range'.$rand_id.'" ).val() ) ],
													slide: function( event, ui ) {
														';
													$woo_currency_symbol='"<span>'.$woo_currency_symbol.'</span>"';
													if($woo_currency_pos=='left_space'){
														$form_output.='jQuery( "#amount_main_price'.$rand_id.'" ).html('.$woo_currency_symbol.'+" "+number_format ( ui.values[ 0 ] ) + " - " + '.$woo_currency_symbol.'+" "+number_format ( ui.values[ 1 ] ) );';
													}else if($woo_currency_pos=='left'){
														$form_output.='jQuery( "#amount_main_price'.$rand_id.'" ).html(  '.$woo_currency_symbol.'+number_format ( ui.values[ 0 ] ) + " - " + '.$woo_currency_symbol.'+number_format ( ui.values[ 1 ] ) );';	
													}else if($woo_currency_pos=='right_space'){
														$form_output.='jQuery( "#amount_main_price'.$rand_id.'" ).html(  number_format ( ui.values[ 0 ] )+" "+'.$woo_currency_symbol.' + " - " + '.$woo_currency_symbol.' +" "+'.'number_format ( ui.values[ 1 ] )+" "+'.$woo_currency_symbol.' );';
													}else if($woo_currency_pos=='right'){
														$form_output.='jQuery( "#amount_main_price'.$rand_id.'" ).html(  number_format ( ui.values[ 0 ] )+'.$woo_currency_symbol.' + " - " + number_format ( ui.values[ 1 ] )+'.$woo_currency_symbol.' );';
													}
													
												$form_output.='},
													change :function(event, ui) {
														if(jQuery( "#from_main_price_range'.$rand_id.'" ).val()!=ui.values[ 1 ])
														{
															jQuery( "#from_main_price_range'.$rand_id.'" ).val(ui.values[ 0 ]);
															//FOR Fire FORM CHANGE
															jQuery( "#from_main_price_range'.$rand_id.'" ).trigger("change");
														}
														if(jQuery( "#to_main_price_range'.$rand_id.'" ).val()!=ui.values[ 1 ])
														{
															jQuery( "#to_main_price_range'.$rand_id.'" ).val(ui.values[ 1 ] ); 
															 //FOR Fire FORM CHANGE
															jQuery( "#to_main_price_range'.$rand_id.'" ).trigger("change");
														}
													}
												});
											});
										</script>';
									}else if($category_taxonomy_style=='list_style'){
										
										$form_output.='
										<input type="hidden" name="search_from_main_price_range" id="from_main_price_range'.$rand_id.'"data-slider-element="main_price-range'.$rand_id.'"  class="input_price_range title-input from_main_price_range'.$rand_id.'"  value="'.$price_from.'" data-searchfied="'.__('Price Range (From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" title="'.__('Price Range (From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" >
												  <input type="hidden" name="search_to_main_price_range" id="to_main_price_range'.$rand_id.'" data-slider-element="main_price-range'.$rand_id.'" class="input_price_range title-input to_main_price_range'.$rand_id.'" value="'.$price_to.'" data-searchfied="'.__('Price Range (To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" title="'.__('Price Range (To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
										';
										
										$additional_calss='pw_woo_ad_attr_radio';
										$items='
										<label class="woo-checkbox-lbl woo-search-items">
											<span id="main_price-list'.$rand_id.'" class="woo-lbl woo-lbl-main-price" data-min-num="'.$price_min.'" data-max-num="'.$price_max.'">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
										</label>';
										for($i=$price_min;$i<$price_max;$i=($i+$price_step_option))
										{
											$max=$i;
											$max=(($max+$price_step_option)>$price_max ? $price_max:($max+$price_step_option));
											
											$price_from_lbl=$this->display_price($woo_currency_pos,$woo_currency_symbol,$i);
											$price_to_lbl=$this->display_price($woo_currency_pos,$woo_currency_symbol,$max);
											
											$active_class='';
											if($price_from==$i && $price_to==$max){
												$active_class='woo-active-check';
											}
											
											$items.='
											<label class="woo-checkbox-lbl '.$active_class.'">
												<span class="woo-lbl woo-lbl-main-price" data-min-num="'.$i.'" data-max-num="'.$max.'">'.$price_from_lbl.' - '.$price_to_lbl.'</span>
											</label>';
										}

										$form_output.= '
										<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
											<div class="woo-searchfield-title" >'.__('Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
												<div class="woo-search-items item-style-1" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
													'.$items.'
												</div>										
										</div>';

										
									}else if($category_taxonomy_style=='filter_style'){
										
										$form_output.='
										<input type="hidden" name="search_from_main_price_range" id="from_main_price_range'.$rand_id.'"data-slider-element="main_price-range'.$rand_id.'"  class="input_price_range title-input from_main_price_range'.$rand_id.'"  value="'.$price_from.'" data-searchfied="'.__('Price Range (From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" title="'.__('Price Range (From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" >
												  <input type="hidden" name="search_to_main_price_range" id="to_main_price_range'.$rand_id.'" data-slider-element="main_price-range'.$rand_id.'" class="input_price_range title-input to_main_price_range'.$rand_id.'" value="'.$price_to.'" data-searchfied="'.__('Price Range (To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" title="'.__('Price Range (To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
										';
										
										$additional_calss='pw_woo_ad_attr_radio';
										$items='
										<label class="woo-checkbox-lbl ">
											<span id="main_price-list'.$rand_id.'" class="woo-lbl woo-lbl-main-price" data-min-num="'.$price_min.'" data-max-num="'.$price_max.'">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
										</label>';
										
										
										for($i=$price_min;$i<$price_max;$i=($i+$price_step_option))
										{
											$max=$i;
											$max=(($max+$price_step_option)>$price_max ? $price_max:($max+$price_step_option));
											
											$price_from_lbl=$this->display_price($woo_currency_pos,$woo_currency_symbol,$i);
											$price_to_lbl=$this->display_price($woo_currency_pos,$woo_currency_symbol,$max);
											
											$active_class='';
											if($price_from==$i && $price_to==$max){
												$active_class='woo-active-check';
											}
											
											$items.='
											<label class="woo-checkbox-lbl '.$active_class.'">
												<span class="woo-lbl woo-lbl-main-price" data-min-num="'.$i.'" data-max-num="'.$max.'">'.$price_from_lbl.' - '.$price_to_lbl.'</span>
											</label>';
										}
										
										$form_output.= '
										<div class="woo-col-md-12  woo-searchfilter-cnt">
											<div class="woo-searchfilter-title" >'.__('Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
												<div class="woo-search-filter-items '.$additional_calss_preset.'" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
													'.$items.'
												</div>										
										</div>';
										
									}
								}	
								break;

								case "product_status":
								{
									$option_array=array(
													'product_status_featured#Featured'  => __('Featured',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
													'product_status_onsale#On-sale'    => __('On-sale Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
													'product_status_instock#In-Stock'   => __('In Stock Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
													'product_status_outstock#Out-of-Stock'  => __('Out of Stock Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
													);
									if($category_taxonomy_style=='dropdown_style'){
										$form_output.= '
										<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'3').'  woo-col-sm-12">
											<div class="input-group input-group-sm '.$additional_calss_preset.' ">
												<select name="'.$field.'[]" id="'.$field.$rand_id.'" class="search-selectbox '.$field.$rand_id.'" multiple="multiple" data-combotitle="'.__('Product Status',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" data-searchfied="'.__('Product Status',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">';
											foreach($option_array as $key=>$value){
												$seleted='';
												if(is_array($meta) && in_array($key,$meta))
													$seleted="SELECTED";
												$form_output.='<option '.$seleted.' value="'.$key.'">'.$value.'</option>';
											}
										$form_output.= '
												</select>
											</div>
										</div>';
									}else if($category_taxonomy_style=='list_style'){
										$additional_calss='pw_woo_ad_attr_checkbox';
										$items='
										<label class="woo-checkbox-lbl woo-search-items none-value">
											<span  class="woo-lbl" data-value="none">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
										</label>';
										foreach($option_array as $key=>$value)
										{
											$seleted='';
											$active_class='';
											if(is_array($meta) && in_array($key,$meta))
											{
												$seleted="CHECKED";
												$active_class='woo-active-check';
											}
											
											
											$items.='
											<label class="woo-checkbox-lbl woo-search-items '.$active_class.'">
												<input type="checkbox" '.$seleted.' name="'.$field.'[]" value="'.$key.'" class="'.$additional_calss.'  '.$field.$rand_id.'"/>
												<span class="woo-lbl">'.$value.'</span>
											</label>';
										}
										
										$form_output.= '
										<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
											<div class="woo-searchfield-title" >'.__('Product Status',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
												<div class="woo-search-items item-style-1" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
													'.$items.'
												</div>										
										</div>';
									}else if($category_taxonomy_style=='filter_style'){
										$additional_calss='pw_woo_ad_attr_checkbox';
										$items='
										<label class="woo-checkbox-lbl none-value">
											<span  class="woo-lbl" data-value="none">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
										</label>';
										foreach($option_array as $key=>$value)
										{
											$seleted='';
											$active_class='';
											if(is_array($meta) && in_array($key,$meta))
											{
												$seleted="CHECKED";
												$active_class='woo-active-check';
											}
											
											$items.='
											<label class="woo-checkbox-lbl '.$active_class.'">
												<input type="checkbox" '.$seleted.' name="'.$field.'[]" value="'.$key.'" class="'.$additional_calss.'  '.$field.$rand_id.'"/>
												<span class="woo-lbl">'.$value.'</span>
											</label>';
										}
										
										$form_output.= '
										<div class="woo-col-md-12 woo-searchfilter-cnt ">
											<div class="woo-searchfilter-title" >'.__('Product Status',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
												<div class="woo-search-filter-items '.$additional_calss_preset.'" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
													'.$items.'
												</div>										
										</div>';
									}
								}
								break;
								
								case "title":
								{
									$html='
									<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'6').'  woo-col-sm-12">
										<div class="input-group input-group-sm '.$additional_calss_preset.' ">
												<input type="text" name="'.$field.'" id="'.$field.$rand_id.'" class="form-control title-input '.$field.$rand_id.'" value="'. $meta .'" placeholder="'.__('Product Title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" title="'.__('Product Title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" data-searchfied="'.__('Keywords',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
										</div>
									</div>';							
									$title_input .=$html;
								}
								break;
								
							}//END switch
							
						}//END foreach
					}
				}
				
				
				//ORDER
				if($pw_sf_show_orders=='on' && $pw_sf_part!='pw_woo_ad_grid_widget' && !isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel'])){
					if(is_array($pw_sf_orders) && sizeof($pw_sf_orders)>0)
					{
						$orders_array=
							array(
								'title'				=> __('Title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'date'				=> __('Date',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'_price'			=> __('Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'_regular_price'	=> __('Regular Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'_sale_price'		=> __('Sale Price',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'_sku'				=> __('SKU',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'total_sales'		=> __('Number Of Sales',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'_featured'			=> __('Featured Products',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'num_stock'			=> __('Stock Quality',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'ID'				=> __('ID',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'author'			=> __('Author',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'modified'			=> __('Modified',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'rand'				=> __('Random',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'comment_count'		=> __('Comment Count',__PW_WOO_AD_SEARCH_TEXTDOMAIN__),
								'menu_order'		=> __('Menu Order',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)
							);
						
						$pw_sf_orders=array_filter($pw_sf_orders);
						
						///////////////////////////////////////
						///////////ORDER TYPE /////////
						///////////////////////////////////////
						
						if($category_taxonomy_style=='dropdown_style'){
							$form_output.='
							<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'3').'  woo-col-sm-4">
									<div class="input-group input-group-sm  '.$additional_calss_preset.'">
											<select name="pw_sf_orderby" class="search-selectbox "  data-combotitle="'.__('Sort By',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" >';
						
								foreach($pw_sf_orders as $orders)
								{
									$form_output.= '<option value="'.$orders.'">'.$orders_array[$orders].'</option>';
								}
								$form_output.= '</select>
									</div>
							</div>
							';
						}else if($category_taxonomy_style=='list_style'){
							$additional_calss='pw_woo_ad_attr_radio';
							$items='
							<label class="woo-checkbox-lbl woo-search-items none-value">
								<span  class="woo-lbl" data-value="">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
							</label>';
							$i=0;
							foreach($pw_sf_orders as $orders)
							{
								$seleted='';
								$active_class="";
								if($i==0){
									$seleted='checked';
									$active_class="woo-active-check";
								}
								$i++;	
									
								$items.='
								<label class="woo-checkbox-lbl woo-search-items '.$active_class.'">
									<input type="radio" name="pw_sf_orderby" value="'.$orders.'" class="'.$additional_calss.'  '.$orders.$rand_id.'" '.$seleted.'/>
									<span class="woo-lbl">'.$orders_array[$orders].'</span>
								</label>';
							}
							
							$form_output.= '
							<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
								<div class="woo-searchfield-title" >'.__('Order By',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
									<div class="woo-search-items item-style-1" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
										'.$items.'
									</div>										
							</div>';
							
							$form_output.= '
							<script type="text/javascript"> 
								jQuery(document).ready(function(){
									jQuery(".pw_woo_ad_attr_radio").click(function(){
																							jQuery(this).parent().parent().find(".woo-search-items").removeClass("woo-active-check");
										jQuery(this).parent().addClass("woo-active-check");
										//jQuery("#pw_sf_orderby'.$rand_id.'").val(jQuery(this).val());
										//jQuery("#pw_sf_orderby'.$rand_id.'").trigger("change");
									});
								});
							</script>';	
						}else if($category_taxonomy_style=='filter_style'){
							$additional_calss='pw_woo_ad_attr_radio';
							$items='
							<label class="woo-checkbox-lbl none-value">
								<span  class="woo-lbl" data-value="">'.__('None',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
							</label>';
							$i=0;
							foreach($pw_sf_orders as $orders)
							{
								$seleted='';
								$active_class="";
								if($i==0){
									$seleted='checked';
									$active_class="woo-active-check";
								}
								$i++;	
									
								$items.='
								<label class="woo-checkbox-lbl '.$active_class.'">
									<input type="radio" name="pw_sf_orderby" value="'.$orders.'" class="'.$additional_calss.'  '.$orders.$rand_id.'" '.$seleted.'/>
									<span class="woo-lbl">'.$orders_array[$orders].'</span>
								</label>';
							}
							
							$form_output.= '
							<div class="woo-col-md-12 woo-searchfilter-cnt">
								<div class="woo-searchfilter-title" >'.__('Order By',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
									<div class="woo-search-filter-items '.$additional_calss_preset.'" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
										'.$items.'
									</div>										
							</div>';
							
							$form_output.= '
							<script type="text/javascript"> 
								jQuery(document).ready(function(){
									jQuery(".pw_woo_ad_attr_radio").click(function(){
																							jQuery(this).parent().parent().find(".woo-checkbox-lbl").removeClass("woo-active-check");
										jQuery(this).parent().addClass("woo-active-check");
										//jQuery("#pw_sf_orderby'.$rand_id.'").val(jQuery(this).val());
										//jQuery("#pw_sf_orderby'.$rand_id.'").trigger("change");
									});
								});
							</script>';	
						}
						
						///////////////////////////////////////
						///////////ORDER - ASC - DESC /////////
						///////////////////////////////////////
						
						if($category_taxonomy_style=='dropdown_style'){
							$form_output.= '
								<div class="archive-form-col price-wrapper '.$additional_calss_preset.'">
										<div class="input-group input-group-sm ">
											<input type="hidden" name="pw_sf_order" id="pw_sf_order'.$rand_id.'" value="'.$pw_sf_order_type.'"/>
											<div class="view-type-cnt">
												<div class="pw-order '.($pw_sf_order_type=='ASC' ? "active":"").'" data-order="ASC" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" title="'.__('ASC Order',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'"><i class="fa fa-arrow-circle-o-up"></i></div>
												<div class="pw-order '.($pw_sf_order_type=='DESC' ? "active":"").'" data-order="DESC" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" title="'.__('DESC  Order',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'"><i class="fa fa-arrow-circle-o-down" ></i></div>
											</div>
										</div>
									</div>';
						}else if($category_taxonomy_style=='list_style'){
							
							$additional_calss='pw_woo_ad_attr_order';
							$items='
							<label class="woo-checkbox-lbl woo-search-items '.($pw_sf_order_type=='ASC' ? "woo-active-check":"").'">
								<input type="radio" name="pw_sf_order_radio" value="'.$orders.'" class="pw-order '.$additional_calss.'  '.$orders.$rand_id.'" data-order="ASC" value="ASC" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" '.($pw_sf_order_type=='ASC' ? "checked":"").'/>
								<span class="woo-lbl">'.__('Ascending',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
							</label>
							
							<label class="woo-checkbox-lbl woo-search-items '.($pw_sf_order_type=='DESC' ? "woo-active-check":"").'">
								<input type="radio" name="pw_sf_order_radio" value="'.$orders.'" class="pw-order '.$additional_calss.'  '.$orders.$rand_id.'" data-order="DESC" value="DESC" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" '.($pw_sf_order_type=='DESC' ? "checked":"").'/>
								<span class="woo-lbl">'.__('Descending',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
							</label>
							';
							
							$form_output.= '
							<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
								<div class="woo-searchfield-title" >'.__('Order Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
									<div class="woo-search-items item-style-1" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
										'.$items.'
									</div>										
							</div>';
							
							$form_output.= '
							<script type="text/javascript"> 
								jQuery(document).ready(function(){
									jQuery(".pw_woo_ad_attr_radio").click(function(){
																							jQuery(this).parent().parent().find(".woo-search-items").removeClass("woo-active-check");
										jQuery(this).parent().addClass("woo-active-check");
									});
									
									jQuery(".pw_woo_ad_attr_order").click(function(){
																							jQuery(this).parent().parent().find(".woo-search-items").removeClass("woo-active-check");
										jQuery(this).parent().addClass("woo-active-check");
									});
									
								});
							</script>';
						}else if($category_taxonomy_style=='filter_style'){
							
							$additional_calss='pw_woo_ad_attr_order';
							$items='
							<label class="woo-checkbox-lbl  '.($pw_sf_order_type=='ASC' ? "woo-active-check":"").'">
								<input type="radio" name="pw_sf_order_radio" value="'.$orders.'" class="pw-order '.$additional_calss.'  '.$orders.$rand_id.'" data-order="ASC" value="ASC" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" '.($pw_sf_order_type=='ASC' ? "checked":"").'/>
								<span class="woo-lbl">'.__('Ascending',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
							</label>
							
							<label class="woo-checkbox-lbl  '.($pw_sf_order_type=='DESC' ? "woo-active-check":"").'">
								<input type="radio" name="pw_sf_order_radio" value="'.$orders.'" class="pw-order '.$additional_calss.'  '.$orders.$rand_id.'" data-order="DESC" value="DESC" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" '.($pw_sf_order_type=='DESC' ? "checked":"").'/>
								<span class="woo-lbl">'.__('Descending',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
							</label>
							';
							
							$form_output.= '
							<div class="woo-col-md-12 woo-searchfilter-cnt">
								<div class="woo-searchfilter-title" >'.__('Order Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
									<div class="woo-search-filter-items '.$additional_calss_preset.'" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
										'.$items.'
									</div>										
							</div>';
							
							$form_output.= '
							<script type="text/javascript"> 
								jQuery(document).ready(function(){
									jQuery(".pw_woo_ad_attr_order").click(function(){
																							jQuery(this).parent().parent().find(".woo-checkbox-lbl").removeClass("woo-active-check");
										jQuery(this).parent().addClass("woo-active-check");
									});
									
								});
							</script>';
						}
					}
				}
				
				
				if($pw_sf_switch_icon=='on' && $pw_sf_display_type!='style_2' && $pw_sf_display_type!='style_4' && !isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']))
				{
					if($category_taxonomy_style=='dropdown_style' || $category_taxonomy_style=='list_style'){	
						$form_output.='
							<div class="archive-form-col price-wrapper '.$additional_calss_preset.'">
								<div class="input-group input-group-sm  ">
									<div class="view-type-cnt">
											<div title="'.__('Grid View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="pw_view_type view-btn pl-gridview '.($pw_sf_grid_type=='grid' && $pw_sf_display_type!='style_2' && $pw_sf_display_type!='style_4' ? "active":"").' " data-viewtype="'.$pw_sf_display_type.'" id="grid_view" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" ><i class="fa fa-th-large"></i></div>
											<div title="'.__('List View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" class="pw_view_type view-btn pl-listview '.($pw_sf_display_type=='style_2' || $pw_sf_grid_type=='list' ? "active":"").'" data-viewtype="style_2" id="list_view" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" ><i class="fa fa-th-list"></i></div>
									 </div>
								</div>
							</div>';
					}else if($category_taxonomy_style=='list_style'){
							
						$additional_calss='pw_woo_ad_attr_switch';
						$items='
						<label class="woo-checkbox-lbl woo-search-items '.($pw_sf_grid_type=='grid' && $pw_sf_display_type!='style_2' && $pw_sf_display_type!='style_4' ? "woo-active-check":"").'">
							<input type="radio" name="pw_sf_orderby" value="'.$orders.'" class="pw_view_type '.$additional_calss.'  '.$field.$rand_id.'" value="'.$pw_sf_display_type.'" data-viewtype="'.$pw_sf_display_type.'" id="grid_view" data-form-id="#'.$pw_sf_part."_form".$rand_id.'" '.($pw_sf_grid_type=='grid' && $pw_sf_display_type!='style_2' && $pw_sf_display_type!='style_4' ? "CHECKED":"").'/>
							<span class="woo-lbl">'.__('Grid View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
						</label>
						
						<label class="woo-checkbox-lbl woo-search-items '.($pw_sf_display_type=='style_2' || $pw_sf_grid_type=='list' ? "woo-active-check":"").'">
							<input type="radio" name="pw_sf_orderby" value="'.$orders.'" class="pw_view_type '.$additional_calss.'  '.$field.$rand_id.'" value="style_2" data-form-id="#'.$pw_sf_part."_form".$rand_id.'"  data-viewtype="style_2" id="list_view" '.($pw_sf_display_type=='style_2' || $pw_sf_grid_type=='list' ? "CHECKED":"").'/>
							<span class="woo-lbl">'.__('List View',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</span>
						</label>
						';
						
						$form_output.= '
						<div class="woo-col-md-'.(($pw_sf_type=='search_left_sticky') || ($pw_sf_type=='search_right_sticky') || $pw_sf_type=='search_sidebar'?'12':'2').'  woo-searchfield-col">
							<div class="woo-searchfield-title" >'.__('Switching Type Type',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</div>
								<div class="woo-search-items item-style-1" data-form-id="#'.$pw_sf_part."_form".$rand_id.'">
									'.$items.'
								</div>										
						</div>';
						
						$form_output.= '
						<script type="text/javascript"> 
							jQuery(document).ready(function(){
								jQuery(".pw_woo_ad_attr_switch").click(function(){
																						jQuery(this).parent().parent().find(".woo-search-items").removeClass("woo-active-check");
									jQuery(this).parent().addClass("woo-active-check");
								});
								
							});
						</script>';
					}
					
					if($pw_sf_display_type=='style_2' || $pw_sf_grid_type=='list')
					{
						$pw_sf_display_type='style_2';
					}
				}
				
				if(((is_array($pw_sf_fields) && sizeof($pw_sf_fields)>0) || (is_array($pw_sf_taxonomies) && sizeof($pw_sf_taxonomies)>0)) && $pw_sf_show_filters=='on' && $pw_sf_part!='pw_woo_ad_grid_widget')
				{
					if(is_array($pw_sf_fields) && sizeof($pw_sf_fields)>0){
						$form_output.= '<input type="hidden" name="pw_sf_switch_fields" id="pw_sf_switch_fields" value="'.implode(',',$pw_sf_fields).'">';
					}
							
					if($pw_sf_enable_reset_btn=='on'){				
						$form_output.= '
						<div class="archive-form-col price-wrapper '.$additional_calss_preset.'">
							<div class="input-group input-group-sm ">
								<div class="reset-type-cnt">
									<div title="'.__('Reset Search',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" id="pw_map_reset" class="pw_map_reset view-btn" data-form-id="'.$pw_sf_part.'_form'.$rand_id.'"><i class="fa fa-undo"></i></div>
							</div>
								</div>
						</div>';
					}
				}else
				{
					$form_output.= '<input type="hidden" name="pw_sf_switch_fields" id="pw_sf_switch_fields" value="">';
				}
				
				
				//Control FIelds and Pagination
				$form_output.= '<input type="hidden" name="pw_sf_post_type" id="pw_sf_post_type'.$rand_id.'" value="'.$pw_sf_post_type.'">';
				$form_output.= '<input type="hidden" name="pw_sf_rand_id" id="pw_sf_rand_id'.$rand_id.'" value="'.$rand_id.'">';
				$form_output.= '<input type="hidden" name="pw_sf_part" id="pw_sf_part" value="'.$pw_sf_part.'">';
				$form_output.= '<input type="hidden" name="pw_sf_display_type" id="pw_sf_display_type'.$rand_id.'" value="'.$pw_sf_display_type.'">';
				$form_output.= '<input type="hidden" name="pw_sf_grid_type" id="pw_sf_grid_type'.$rand_id.'" value="'.$pw_sf_grid_type.'">';
				$form_output.= '<input type="hidden" name="pw_sf_post_per_page" id="pw_sf_post_per_page" value="'.$pw_sf_post_per_page.'">';
				$form_output.= '<input type="hidden" name="pw_sf_pagination_type" id="pw_sf_pagination_type" value="'.$pw_sf_pagination_type.'">';
				$form_output.= '<input type="hidden" name="pw_sf_pagination_paged" id="pw_sf_pagination_paged'.$rand_id.'" value="1">';
				$form_output.= '<input type="hidden" name="pw_sf_pagination_total_page" id="pw_sf_pagination_total_page'.$rand_id.'" value="">';
				$form_output.= '<input type="hidden" name="pw_sf_target_element_id" id="pw_sf_target_element_id" value="'.$pw_sf_target_element_id.'">';
				$form_output.= '<input type="hidden" name="pw_sf_taxonomy" id="pw_sf_taxonomy" value="'.$pw_sf_taxonomy.'">';
				$form_output.= '<input type="hidden" name="pw_sf_taxonomy_id" id="pw_sf_taxonomy_id" value="'.$pw_sf_taxonomy_id.'">';
				$form_output.= '<input type="hidden" name="pw_sf_order" id="pw_sf_order'.$rand_id.'" value="'.($pw_sf_order_type!='' ? $pw_sf_order_type:'ASC').'" />';
				$form_output.= '<input type="hidden" name="pw_sf_shortcode_id" id="pw_sf_shortcode_id" value="'.$pw_sf_shortcode_id.'"/>';
				
				//$pw_sf_type='search_top';
				
				if($pw_sf_part=='pw_woo_ad_grid_widget'){
					$form_output.= '
					<div class="woo-col-md-12  woo-col-sm-4">
						<button type="submit" class="btn btn-primary widget-btn"><i class="fa fa-search"></i> '.__('Search',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</button>
						<button type="button" id="pw_map_reset" class="pw_map_reset btn btn-primary widget-btn" data-form-id="'.$pw_sf_part.'_form'.$rand_id.'"><i class="fa fa-undo"></i> '.__('Reset Search',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'</button></div>';
				}
				
				switch($pw_sf_type)
				{
					case "search_top":
					{
						$enable_toggle=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'search_enable_toggle','custom_field','yes');
						
						$pw_form_holder='';
						if(($pw_sf_switch_icon=='on' || $pw_sf_show_filters=='on' || $pw_sf_show_orders=='on') && ($enable_toggle=='yes')){
							$pw_form_holder='
							<span class="search_form_toggle_btn" data-content-id="#searh_form_toggle_content'.$rand_id.'" title="'.$search_form_header_title.'">
								<i class="fa fa-bars"></i>
							</span>
							<script type="text/javascript">
								jQuery(document).ready(function(){
									jQuery("#searh_form_toggle_content'.$rand_id.'").hide();
								});
							</script>';
						}else
						{
							$pw_form_holder='
							<script type="text/javascript">
								jQuery(document).ready(function(){
									jQuery("#searh_form_toggle_content'.$rand_id.'").show();
								});
							</script>';
						}
						$form_output =$pw_form_holder.'
						
						<div  class="search_form_toggle_cnt" id="searh_form_toggle_content'.$rand_id.'">
							<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
								<div class="woo-row">
									'.$title_input.$combo_input.$form_output.' 
								</div>
							</form>
						</div>';
					}
					break;
					
					case "search_left_sticky":
					{
						if($pw_sf_switch_icon=='on' || $pw_sf_show_filters=='on' || $pw_sf_show_orders=='on'){
								
							
							$form_output= '
							<div id="search_sticky" class="wt-pw-stick rtooltip pulsegrow-eff wt-pw-stick-left wt-pw-stick-light pw-left-stick" style="top:'.$search_sticky_margin_top.'px" data-id="'.$rand_id.'" title="'.$search_form_header_title.'">
									<span class="wt-pw-title" rel="tipsye" original-title="'.$search_form_header_title.'">'.$search_sticky_icon.'</span>
							</div>
							
							<div class="wt-pw-content wt-pw-content-light pw-content-search_sticky wt-pw-content-left  dis-'.$rand_id.'">
							<div class="wt-pw-content-close" title="'.__('Close',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'"></div>
							<h3>'.$search_form_header_title.'</h3>
							<div class="wt-scrollbarcnt wt-sticky-scroller-search">
								<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
								<div class="viewport" style="height:'.$search_sticky_height.'px">
									<div class="overview">
										<div id="favorite_div_content_left">
											<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
												<div class="woo-row" >
													'.$title_input.$combo_input.$form_output.' 
												</div>
											</form>
										</div> 
									</div>
								</div>	
							</div>
							</div>
							
							
							';
						}else{
							$form_output='<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
								<div class="woo-row" >
									'.$title_input.$combo_input.$form_output.' 
								</div>
							</form>';
						}
					}
					break;
					
					case "search_right_sticky":
					{
						if($pw_sf_switch_icon=='on' || $pw_sf_show_filters=='on' || $pw_sf_show_orders=='on'){
							$form_output= '
							<div id="search_sticky" class="wt-pw-stick ltooltip pulsegrow-eff wt-pw-stick-right wt-pw-stick-light pw-right-stick" style="top:'.$search_sticky_margin_top.'px" data-id="'.$rand_id.'" title="'.$search_form_header_title.'">
									<span class="wt-pw-title" rel="tipsye" original-title="'.$search_form_header_title.'">'.$search_sticky_icon.'</span>
							</div>
							
							<div class="wt-pw-content wt-pw-content-light pw-content-search_sticky wt-pw-content-right  dis-'.$rand_id.' ">
							<div class="wt-pw-content-close" title="'.__('Close',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'"></div>
							<h3>'.$search_form_header_title.'</h3>
							<div class="wt-scrollbarcnt wt-sticky-scroller-search">
								<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
								<div class="viewport" style="height:'.$search_sticky_height.'px">
									<div class="overview">
										<div id="favorite_div_content_right">
											<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
												<div class="woo-row" >
													'.$title_input.$combo_input.$form_output.' 
												</div>
											</form>
										</div> 
									</div>
								</div>	
							</div>
							</div>
							
							';
						}else{
							$form_output='
							<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
								<div class="woo-row" >
									'.$title_input.$combo_input.$form_output.' 
								</div>
							</form>';
						}
							
					}
					break;
					
					case "search_sidebar":
					{
						if($pw_sf_switch_icon=='on' || $pw_sf_show_filters=='on' || $pw_sf_show_orders=='on'){
							$form_output= '
							
							
							
							<div>
								<h3>'.$search_form_header_title.'</h3>
								<div class="overview">
									<div id="favorite_div_content_sidebar">
										<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
											<div class="woo-row" >
												'.$title_input.$combo_input.$form_output.' 
											</div>
										</form>
									</div> 
								</div>
							</div>
							
							';
						}else{
							$form_output='
							<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
								<div class="woo-row" >
									'.$title_input.$combo_input.$form_output.' 
								</div>
							</form>';
						}
					}
					break;
					
					case "serach_popup":
					{
						if($pw_sf_switch_icon=='on' || $pw_sf_show_filters=='on' || $pw_sf_show_orders=='on'){
							$form_output ='
							<span class="search_form_popup_btn" data-content-id="#searh_form_popup_content'.$rand_id.'" title="'.__('Advanced Search','gt_wmpl').'">
								'.$search_sticky_icon.'
							</span>	
							
							<div class="searh_form_popup_content wt-sticky-scroller-search" id="searh_form_popup_content'.$rand_id.'">
								<div class="wt-pw-content-popup-close" data-content-id="#searh_form_popup_content'.$rand_id.'" title="'.__('Close',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'"></div>
								<h3>'.$search_form_header_title.'</h3>
								<div class="wt-scrollbarcnt ">
									<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
									<div class="viewport" style="height:'.$search_sticky_height.'px">
										<div class="overview">
											<div id="favorite_div_contents">
												<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
													<div class="woo-row" >
														'.$title_input.$combo_input.$form_output.' 
													</div>
												</form>
											</div> 
										</div>
									</div>	
								</div>
								</div>';
						}else{
							$form_output='
							<form id="'.$pw_sf_part."_form".$rand_id.'" class="gt-searchform" action="'.$form_action.'" method="post">
								<div class="widget widget-style2 " >
									'.$form_output.' 
								</div>
							</form>';
						}
					}
					break;
				}
				
				if($pw_sf_part=='pw_woo_ad_grid_widget'){
					$form_output .='
					<script type="text/javascript">
						jQuery(document).ready(function(){
							setTimeout(function(){
								//confirm(jQuery("html").find("div[id*=\"result_\"]").html());
								//jQuery("html").find("div[id*=\"result_\"]").html("REZA");	
								//confirm(jQuery("div[id*=\"result_\"][class*=\"woo-row\"]").first().html());
								//jQuery("div[id*=\"result_\"][class*=\"woo-row\"]").first().addClass("REZA");	
							},500);
						});
					</script>
					';
				}else{
					$form_output .='
					<script type="text/javascript"> 
						jQuery(document).ready(function(){
							jQuery("<div id=\"'.$pw_sf_target_element_id.'_yoursearch\" class=\"selected-result\"></div>").insertBefore("#'.$pw_sf_target_element_id.'");
							jQuery("<div id=\"'.$pw_sf_target_element_id.'_temp\" style=\"display:none\"></div>").insertBefore("#'.$pw_sf_target_element_id.'");
							//jQuery("#'.$pw_sf_part.'_form'.$rand_id.' input").unbind();
							setTimeout(function(){
								jQuery("#'.$pw_sf_part.'_form'.$rand_id.' input").change(function() {
									jQuery("#pw_sf_pagination_total_page'.$rand_id.'").val("1");
								
									jQuery("#pw_sf_pagination_paged'.$rand_id.'").val("1");
									ajax_action("#'.$pw_sf_part.'_form'.$rand_id.'","#'.$pw_sf_target_element_id.'","pw_woo_ad_search_action_build_query_sql_result");
								});
							},500);
							
							
							
							ajax_action("#'.$pw_sf_part.'_form'.$rand_id.'","#'.$pw_sf_target_element_id.'","pw_woo_ad_search_action_build_query_sql_result");
						});
					</script>
					';
				}
				
				
				/*global $woocommerce;
				$product_variation = new WC_Product_Variation($_POST['variation_id']);
				$regular_price = $product_variation->regular_price;
				
				$form_output.=$regular_price;*/
				
				return $form_output;
			}

			public function build_search_query($_FIELDS)
			{
				global $pw_woo_ad_main_class;
				global $_chosen_attributes, $wpdb, $wp; 
				
				$your_search=array();
				
				$rand_id=isset($_FIELDS['pw_sf_rand_id']) ? $_FIELDS['pw_sf_rand_id']:'';
				
				$pw_sf_part=isset($_FIELDS['pw_sf_part']) ? $_FIELDS['pw_sf_part']:'';

				$query_posts_per_page=10;
				$query_post_type='properties';
				$query_meta_key='';
				$query_orderby='date';
				$query_order='ASC';
				$pw_order='';
				$pw_orderby='';
				$query_by_id_in='';
				$query_by_id_not_in='';
				$query_taxonomies=array();

				//FETCH ALL SHORTCODE DETAILS
				$pw_woo_ad_main_class->fetch_custom_fields($_FIELDS['pw_sf_shortcode_id']);
				
				
				//APPLY BUILD QUERY TAX/Cat Filter item FOR GRID AND SEARCH_with_buildquery
				$query_tax_query=array('relation' => 'AND');
				$query_meta_query=array('relation' => 'AND');
				$query_tax_with_query=array('relation' => 'AND');
				
				$include_tax_build_query='';
				$exclude_tax_build_query='';
				
				if($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'shortcode_type']!='search'){
					$pw_query=$this->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'build_query_taxonomy','custom_field','');
					if($build_query_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'fetch_type']=='build_query')
					{
						if(isset($pw_query['taxonomy_checkbox'])){				

							$taxonomies=$pw_query['taxonomy_checkbox'];
							foreach($taxonomies as $taxonomy){
								if(isset($pw_query['in_'.$taxonomy]))
								{
									$taxonomy_value=$pw_query['in_'.$taxonomy];
									$include_tax_build_query[$taxonomy]=$taxonomy_value;
								}
								
								if(isset($pw_query['ex_'.$taxonomy]))
								{
									$taxonomy_value=$pw_query['ex_'.$taxonomy];
									$exclude_tax_build_query[$taxonomy]=$taxonomy_value;
								}
							}
						}
						
						if(isset($pw_query['in_ids'])){
							$query_by_id_in=$pw_query['in_ids'];
						}
						
						if(isset($pw_query['ex_ids'])){
							$query_by_id_not_in=$pw_query['ex_ids'];
						}
						
					}else{
							
						$pw_query=$this->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'build_query_taxonomy','custom_field','');
						if($build_query_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'fetch_type']=='build_query')
						{
							if(isset($pw_query['taxonomy_checkbox'])){				
	
								$taxonomies=$pw_query['taxonomy_checkbox'];
								foreach($taxonomies as $taxonomy){
									if(isset($pw_query['in_'.$taxonomy]))
									{
										$taxonomy_value=$pw_query['in_'.$taxonomy];
										$include_tax_build_query[$taxonomy]=$taxonomy_value;
									}
									
									if(isset($pw_query['ex_'.$taxonomy]))
									{
										$taxonomy_value=$pw_query['ex_'.$taxonomy];
										$exclude_tax_build_query[$taxonomy]=$taxonomy_value;
									}
								}
							}
							
							if(isset($pw_query['in_ids'])){
								$query_by_id_in=$pw_query['in_ids'];
							}
							
							if(isset($pw_query['ex_ids'])){
								$query_by_id_not_in=$pw_query['ex_ids'];
							}
							
						}else
						{
							$fetch_type=$build_query_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'fetch_type'];
							switch($fetch_type){
								
								case "on_sale_product":
								{
									$query_by_id_in = woocommerce_get_product_ids_on_sale();
									$query_by_id_in[] = 0;
								}
								break;
								
								case "in_stock_product":
								{
									$query_meta_query[] = array(
										'key' => '_stock_status',
										'value' => "instock",
										'compare' => '=',
									);
								}
								break;
								
								case "out_stock_product":
								{
									$query_meta_query[] = array(
									   'key' => '_stock_status',
									   'value' => "outofstock",
									   'compare' => '=',
									);
								}
								break;
							}
								
							/////////Your Search//////////
							/*$your_search_span='<span id="'.$fetch_type.'" class="ys_items" data-target-element="product_status" data-rand-id="'.$rand_id.'">'.$fetch_type.' <i class="fa fa-times"></i></span>';
							/////////Your Search//////////
							$your_search['product_status']='<span id="ys_product_status" >'.__('Product Status',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : '.$your_search_span.'</span>';				*/	
						}
					
					}
					
					
					
					$query_meta_key='';
					$query_orderby='';
					if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'build_query_order_by'])){
						$pw_query_order=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'build_query_order_by'];
						$public_orders_array=array('ID','date','author','title','modified','rand','comment_count','menu_order');
						if(in_array($pw_query_order,$public_orders_array))
						{
							$query_orderby=$pw_query_order;
						}else
						{
							$query_meta_key=$pw_query_order;
							$query_orderby='meta_value_num';
						}
					}
					
					$query_order='';
					if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'build_query_order_type'])){
						$query_order=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'build_query_order_type'];
					}
					
					$pw_meta_key=$query_meta_key;
					$pw_orderby=$query_orderby;
					$pw_order=$query_order;
					
					
					//Show Hidden Products(s)
					if(!isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'show_hidden_product'])){
						$query_meta_query[] =  array(
						   'key' => '_visibility',
						   'value' => 'visible',
						   'compare' => '='
						 );
						 
					}
				
					//Just Featured products(s)
					if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'featured_product'])){
						$query_meta_query[] =  array(
						   'key' => '_featured',
						   'value' => 'yes',
						   'compare' => '='
						 );
						 
						
					}
					
					//Hide Free products(s)
					if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'hide_free_product'])){
						$query_meta_query[] =  array(
						   'key' => '_price',
						   'value' => '',
						   'compare' => '!='
						 );
					}
					
				}
				

				
				
				//FOR PROPERTY TAXONOMY ARCHIVE PAGE. Example: property_type/apartment/ or contract_type/rent/
				if(isset($_FIELDS['pw_sf_taxonomy']) && $_FIELDS['pw_sf_taxonomy']!='')
				{
					$query_tax_query[]=array(
						'taxonomy' => $_FIELDS['pw_sf_taxonomy'],
						'field'    => 'id',
						'terms'    => array($_FIELDS['pw_sf_taxonomy_id']),
						'operator' => 'IN',
					);
				}

				$post_name=$_FIELDS['pw_sf_post_type'];
				$option_data='';
				$param_line='';
				
				$all_tax=get_object_taxonomies( $post_name );
				$current_value=array();
				if(is_array($all_tax) && count($all_tax)>0){
					$post_type_label=get_post_type_object( $post_name );
					$label=$post_type_label->label ; 
					$param_line .='<div style=" text-transform:uppercase;border-bottom:2px solid #333;width:100%;margin:20px 0px">'.$label.' Taxonomies</div>';
					
					//FETCH TAXONOMY
					foreach ( $all_tax as $tax ) {
						$taxonomy=get_taxonomy($tax);	
						$values=$tax;
						$label=$taxonomy->label;
					
						if(isset($_FIELDS[$tax]) && !empty($_FIELDS[$tax]))
						{
							$property_type=$_FIELDS[$tax];
														
							if(isset($include_tax_build_query[$tax])){
								//$property_type=array_merge($_FIELDS[$tax],$include_tax_build_query[$tax]);
								//$property_type=array_unique($property_type);
								
								$query_tax_with_query[]=array(
									'taxonomy' => $tax,
									'field'    => 'id',
									'terms'    => $include_tax_build_query[$tax],
									'operator' => 'IN',
									//'include_children' => false
								);
								
							}
							
							if(isset($exclude_tax_build_query[$tax]))
							{
								$query_tax_with_query[]=array(
									'taxonomy' => $tax,
									'field'    => 'id',
									'terms'    => $exclude_tax_build_query[$tax],
									'operator' => 'Not IN',
								);
							}
							
							if(count(array_filter($property_type))>0 && !in_array('0',$property_type))
							{
								$query_tax_query[]=array(
									'taxonomy' => $tax,
									'field'    => 'id',
									'terms'    => $property_type,
									'operator' => 'IN',
									//'include_children' => false
								);
								
								if(isset($exclude_tax_build_query[$tax]))
								{
									$property_type=$exclude_tax_build_query[$tax];
									$query_tax_query[]=array(
										'taxonomy' => $tax,
										'field'    => 'id',
										'terms'    => $property_type,
										'operator' => 'Not IN',
									);
								}
							}							
							/////////Your Search//////////
							if(count(array_filter($property_type))>0){

								$your_search_span='';
								foreach($property_type as $ys_items)
								{
									$tax_name=get_term_by( 'id', $ys_items, $tax);
									$tax_name=$tax_name->name;
									$your_search_span.='<span id="'.$ys_items.'" class="ys_items" data-target-element="'.$tax.'" data-rand-id="'.$rand_id.'">'.$tax_name.' <i class="fa fa-times"></i></span>';
								}
								$your_search[$tax]='<span id="ys_'.$tax.'" >'.__($label,__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : '.$your_search_span.'</span>';
							}
						}else{
							
							if(isset($include_tax_build_query[$tax])){
								$query_tax_with_query[]=array(
									'taxonomy' => $tax,
									'field'    => 'id',
									'terms'    => $include_tax_build_query[$tax],
									'operator' => 'IN',
								);
								
							}
							
							if(isset($exclude_tax_build_query[$tax]))
							{
								$query_tax_with_query[]=array(
									'taxonomy' => $tax,
									'field'    => 'id',
									'terms'    => $exclude_tax_build_query[$tax],
									'operator' => 'Not IN',
								);
							}
						}
					}
				}
				
				
				//////GET MIN AND MAX PRICE/////////////
				$min = floor( $wpdb->get_var(
					$wpdb->prepare('
						SELECT min(meta_value + 0)
						FROM %1$s
						LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
						WHERE ( meta_key = \'%3$s\' OR meta_key = \'%4$s\' )
						AND meta_value != ""
					', $wpdb->posts, $wpdb->postmeta, '_price', '_min_variation_price' )
				) );

				$max = ceil( $wpdb->get_var(
					$wpdb->prepare('
						SELECT max(meta_value + 0)
						FROM %1$s
						LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
						WHERE meta_key = \'%3$s\'
					', $wpdb->posts, $wpdb->postmeta, '_price' )
				) );
				//Sale Price Range - Price Type
				$from_main_price=(isset($_FIELDS['search_from_main_price_range']) ? esc_attr($_FIELDS['search_from_main_price_range']):'');
				$from_main_price=($from_main_price!=$min ? $from_main_price:'');
				$to_main_price=(isset($_FIELDS['search_to_main_price_range']) ? esc_attr($_FIELDS['search_to_main_price_range']):'');
				$to_main_price=($to_main_price!=$max ? $to_main_price:'');
				
				$price_type='_price';
				
				/*if($to_main_price=='' && $from_main_price=='')
				{
					$query_meta_query[]= array(
							   'key' => $price_type,
							   'value' => '',
							   'compare' => '!='
						   );
				}else */if($to_main_price!='' && $from_main_price!='')
				{
					$query_meta_query[]= array(
								   'key' => $price_type,
								   'value' => array( $from_main_price, $to_main_price),
								   'type' => 'numeric',
								   'compare' => 'BETWEEN'
							   );
							   
					/////////Your Search//////////
					$your_search['from_main_price_range']='<span id="ys_main_price_range" >'.__('Price Ragne(From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : <span class="ys_items" data-target-element="from_main_price_range" data-rand-id="'.$rand_id.'">'.$from_main_price.' <i class="fa fa-times"></i></span></span>';
					$your_search['to_main_price_range']='<span id="ys_main_price_range" >'.__('Price Ragne(To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : <span class="ys_items" data-target-element="to_main_price_range" data-rand-id="'.$rand_id.'">'.$to_main_price.' <i class="fa fa-times"></i></span></span>';
							   
				}else if($to_main_price=='' && $from_main_price!='')
				{
					$query_meta_query[]= array(
								   'key' => $price_type,
								   'value' => $from_main_price,
								   'type' => 'numeric',
								   'compare' => '>='
							   );
					
					/////////Your Search//////////
					$your_search['from_main_price_range']='<span id="ys_main_price_range" >'.__('Price Ragne(From)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : <span class="ys_items" data-target-element="from_main_price_range" data-rand-id="'.$rand_id.'">'.$from_main_price.' <i class="fa fa-times"></i></span></span>';
				}else if($to_main_price!='' && $from_main_price=='')
				{
					$query_meta_query[]= array(
								   'key' => $price_type,
								   'value' =>  $to_main_price,
								   'type' => 'numeric',
								   'compare' => '<='
							   );
					
					/////////Your Search//////////
					$your_search['to_main_price_range']='<span id="ys_main_price_range" >'.__('Price Ragne(To)',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : <span class="ys_items" data-target-element="to_main_price_range" data-rand-id="'.$rand_id.'">'.$to_main_price.' <i class="fa fa-times"></i></span></span>'; 
				}
				
				
				
				//$query_meta_query=array('relation' => 'AND');
				//Product Status
				if ( isset($_FIELDS['product_status']) && !empty($_FIELDS['product_status'])){
					$product_status=$_FIELDS['product_status'];
					
					$your_search_span='';
					
					foreach($product_status as $status){
						
						$arr_status=explode('#',$status);
						$status_value=$arr_status[0];
						$status_lbl=$arr_status[1];
						
						switch($status_value){
							case "product_status_featured":
							{
								$query_meta_query[] =  array(
								   'key' => '_featured',
								   'value' => 'yes',
								   'compare' => '='
								);
							}
							break;
							
							case "product_status_onsale":
							{
								$query_by_id_in = woocommerce_get_product_ids_on_sale();
								$query_by_id_in[] = 0;
							}
							break;
							
							case "product_status_instock":
							{
								$query_meta_query[] = array(
									'key' => '_stock_status',
									'value' => "instock",
									'compare' => '=',
								);
							}
							break;
							
							case "product_status_outstock":
							{
								$query_meta_query[] = array(
								   'key' => '_stock_status',
								   'value' => "outofstock",
								   'compare' => '=',
								);
							}
							break;
						}
						
						/////////Your Search//////////
						$your_search_span.='<span id="'.$status.'" class="ys_items" data-target-element="product_status" data-rand-id="'.$rand_id.'">'.$status_lbl.' <i class="fa fa-times"></i></span>';
						
					}
					
					/////////Your Search//////////
					$your_search['product_status']='<span id="ys_product_status" >'.__('Product Status',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : '.$your_search_span.'</span>';
					
				}
				
				//print_r($_FIELDS);
					
			
				
				//TITLE
				$query_title='';
				if ( isset($_FIELDS['title']) && !empty($_FIELDS['title'])){
					$query_title=esc_attr($_FIELDS['title']);
					
					/////////Your Search//////////
					$your_search['title']='<span id="ys_title" >'.__('Title',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' : <span class="ys_items" data-target-element="title" data-rand-id="'.$rand_id.'">'.$query_title.' <i class="fa fa-times"></i></span></span>';
				}	
				
				
		
				//ORDER
				
				if ( isset($_FIELDS['pw_sf_order']) && !empty($_FIELDS['pw_sf_order'])){
					$pw_order=esc_attr($_FIELDS['pw_sf_order']);
				}
				
				if ( isset($_FIELDS['pw_sf_orderby']) && !empty($_FIELDS['pw_sf_orderby'])){
					$pw_meta_key='';
					$pw_orderby='';
					$pw_orderby=esc_attr($_FIELDS['pw_sf_orderby']);
		
					
					$public_orders_array=array('ID','date','author','title','modified','rand','comment_count','menu_order');
					if(!in_array($pw_orderby,$public_orders_array))
					{
						$pw_meta_key=$pw_orderby;
						$pw_orderby='meta_value_num';
					}
				}
				
				//die(print_r($_FIELDS));

				//PAGINATION
				$pw_post_per_page=-1;
				if ( isset($_FIELDS['pw_sf_post_per_page']) && !empty($_FIELDS['pw_sf_post_per_page'])){
					$pw_post_per_page=esc_attr($_FIELDS['pw_sf_post_per_page']);
				}
				
				$pw_paged=1;
				if ( isset($_FIELDS['pw_sf_pagination_paged']) && !empty($_FIELDS['pw_sf_pagination_paged'])){
					$pw_paged = esc_attr($_FIELDS['pw_sf_pagination_paged']);
				}
				
				//POST TYPE
				$post_type='post';
				if ( isset($_FIELDS['pw_sf_post_type']) && !empty($_FIELDS['pw_sf_post_type'])){
					$post_type = esc_attr($_FIELDS['pw_sf_post_type']);
				}

				if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'hide_recent_post'])){
		
					$query_posts_recent=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'hide_recent_post_num','custom_field','1');
					
					$args=array(
								'post_type' => $post_type,
								'post_status'=>'publish',
								
								'posts_per_page'=>$query_posts_recent,
								'orderby' => 'date',
								'order' => 'DESC',
								
								'search_title'   => $query_title,
								'meta_query' => $query_meta_query,
								'tax_query'=>$query_tax_query,
								'post__in'=>$query_by_id_in,
								'post__not_in'=>$query_by_id_not_in,
							 );
					
					$my_query = new WP_Query($args);	
					$recent_posts=array();
					while ( $my_query->have_posts() ) {
						$my_query->the_post();
						$recent_posts[]=get_the_ID();
					}
					
					if(is_array($query_by_id_not_in))
						$query_by_id_not_in=array_merge($query_by_id_not_in,$recent_posts);
					else	
						$query_by_id_not_in=$recent_posts;
				}		
						
				
				if(strtolower($pw_post_per_page)=='all')
					$pw_post_per_page="-1";
						
				//Build Query
				$args_build=array('post_type' => $post_type,
								'post_status'=>'publish',
								
								'posts_per_page'=>-1,
								'meta_key' => $pw_meta_key,
								'orderby' => $pw_orderby,
								'order' => $pw_order,
								//'paged'=>$pw_paged,
								
								'search_title'   => $query_title,
								'meta_query' => $query_meta_query,
								'tax_query'=>$query_tax_with_query,
								'post__in'=>$query_by_id_in,
								'post__not_in'=>$query_by_id_not_in,
							 );
							 
			
							 
				$q1 = get_posts($args_build);			 
				
				$args_selected=array('post_type' => $post_type,
								'post_status'=>'publish',
								
								'posts_per_page'=>-1,
								'meta_key' => $pw_meta_key,
								'orderby' => $pw_orderby,
								'order' => $pw_order,
								//'paged'=>$pw_paged,
								
								'search_title'   => $query_title,
								'meta_query' => $query_meta_query,
								'tax_query'=>$query_tax_query,
								'post__in'=>$query_by_id_in,
								'post__not_in'=>$query_by_id_not_in,
							 );
				
				
				$q2 = get_posts($args_selected);			 
					 
				$post_ids = array();
				$temp_q1=array();
				foreach( $q1 as $item ) {
					$temp_q1[] = $item->ID;
				}
				
				$temp_q2=array();
				foreach( $q2 as $item ) {
					$temp_q2[] = $item->ID;
				}

				
				$merged = array_intersect($temp_q1,$temp_q2);
				
				$unique = array_unique($merged);
				
				$args=array();
				if(count($unique)>0)
				{
					$args = array(
						'post_type'   => $post_type,
						'post_status' =>'publish',
						'posts_per_page'	=> $pw_post_per_page,
						'paged'			=> $pw_paged,			
						'meta_key' => $pw_meta_key,
						'orderby' => $pw_orderby,
						'order' => $pw_order,
						
						'meta_key' => $pw_meta_key,
						'post__in' => $unique,
						
					);
				}
				
				
				/*$args=array('post_type' => $post_type,
								'post_status'=>'publish',
								
								'posts_per_page'=>$pw_post_per_page,
								'meta_key' => $pw_meta_key,
								'orderby' => $pw_orderby,
								'order' => $pw_order,
								'paged'=>$pw_paged,
								
								'search_title'   => $query_title,
								'meta_query' => $query_meta_query,
								'tax_query'=>$query_tax_query,
								'post__in'=>$query_by_id_in,
								'post__not_in'=>$query_by_id_not_in,
							 );*/
				
				
				//die(print_r($args));
				//print_r($args);
				

				global $paged;
				$paged=$pw_paged;
								
				$return_value=array();			 
				$return_value['query']=$args;
				$return_value['your_search']=$your_search;
							 
				return $return_value;		 
							 
			}
			
			public function horizontal_pagination($pages = '', $range = 4,$class='pl-pagination-link-1',$rand_id)
			{  
				 global $pw_woo_ad_main_class;
				 $hor_preset = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_hor_pagenumber_type'];
				 $showitems = ($range * 2)+1;  
			
				 global $paged;
				 $output='';
				 if(empty($paged)) $paged = 1;
			
				 if($pages == '')
				 {
					 global $wp_query;
					 $pages = $wp_query->max_num_pages;
					 if(!$pages)
					 {
						 $pages = 1;
					 }
				 }   
			
				 if(1 != $pages)
				 {
					
					$output.='<div class=\"pagination-cnt hor-'. $hor_preset .'  \" style=\"clear:both\" id=\"pagination-cnt'.$rand_id.'\"><ul class=\"pagination\">';
					 for ($i=1; $i <= $pages; $i++)
					 {
						 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
						 {
							$output.= ($paged == $i)? '<li class=\"active\"><span class=\" pl-currentpage pl-pagination-link  '.$class.'\" id=\"'.$i.'\">'.$i.'</span></li>':'<li><span class=\"pl-pagination-link pl-pagination-link'.$rand_id.' '.$class.' \" id=\"'.$i.'\">'.$i.'</span></li>';
						 }
					 }
					 $output.= "</ul></div>";
				 }
				 $paged=1;
				 return $output;
			}
			
			public function vertical_pagination($pages = '', $range = 4,$class='pl-pagination-link-1',$rand_id)
			{  
				  global $pw_woo_ad_main_class;
				 $ver_preset = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_ver_pagenumber_type'];
				 $ver_direction = $pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'pagination_ver_pagenumber_position'];
				 $showitems = ($range * 2)+1;  
			
				 global $paged;
				 $output='';
				 if(empty($paged)) $paged = 1;
			
				 if($pages == '')
				 {
					 global $wp_query;
					 $pages = $wp_query->max_num_pages;
					 if(!$pages)
					 {
						 $pages = 1;
					 }
				 }   
			
				 if(1 != $pages)
				 {
					
					$output.='<div class=\"pagination-cnt ver-'. $ver_preset .' pagination-ver-'.$ver_direction.' \" style=\"clear:both\" id=\"pagination-cnt'.$rand_id.'\"><ul class=\"pagination\">';
					 for ($i=1; $i <= $pages; $i++)
					 {
						 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
						 {
							$output.= ($paged == $i)? '<li class=\"active\"><span class=\" pl-currentpage pl-pagination-link  '.$class.'\" id=\"'.$i.'\">'.$i.'</span></li>':'<li><span class=\"pl-pagination-link pl-pagination-link'.$rand_id.' '.$class.' \" id=\"'.$i.'\">'.$i.'</span></li>';
						 }
					 }
					 $output.= "</ul></div>";
				 }
				 return $output;
			}
		}
		
		//$GLOBALS['pw_search_framework'] = new PW_SEARCH_FRAMEWORK;
	}
?>
