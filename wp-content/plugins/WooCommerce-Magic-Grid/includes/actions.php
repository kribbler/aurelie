<?php
	//CHANGE STATUS IN ADMIN LIST
	add_action('wp_ajax_pw_woo_ad_search_taxonomy_fetch', 'pw_woo_ad_search_taxonomy_fetchs');
	add_action('wp_ajax_nopriv_pw_woo_ad_search_taxonomy_fetch', 'pw_woo_ad_search_taxonomy_fetch');
	function pw_woo_ad_search_taxonomy_fetch() {
		global $wpdb;
		
		$param_line ='';
		$option_data='';
		$posts=explode(",",$_POST['post_selected']);
		foreach($posts as $post_name){
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
	
				$checked='';
				//if ( in_array($values, explode(",", $current_value)) ) $checked = ' checked="checked"';
				$tax_checked='';
				if(isset($query_taxonomies['pw_'.$tax]))
				{
					$tax_checked="CHECKED";
				}
				$param_line .=' 
				<div style="margin-bottom:10px;">
					<label>
						<input type="checkbox" data-input="post_type" value="pw_'.$tax.'" style="margin-bottom: 10px;" id="pw_checkbox_'.$tax.'" name="pw_taxonomy_checkbox[]" class="pw_taxomomy_checkbox" '.$tax_checked.'> 
						'.$label.'
					</label>
					<br />';
					
	
					$param_line .= '<select name="pw_'.$tax.'[]" class="chosen-select" multiple="multiple" style="width: 531px;" data-placeholder="'.__('Choose',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' '.$label.' ..." id="pw_'.$tax.'">';
					$args = array(
						'taxonomy'       			 =>  $tax,
						'name'          		     =>  'pw_'.$tax.'[]',
						'id'                       =>  'pw_'.$tax,
						'orderby'                  => 'name',
						'order'                    => 'ASC',
						'hide_empty'               => 1,
						'hierarchical'             => 1,
						'exclude'                  => '',
						'include'                  => '',
						'child_of'          		 => 0,
						'number'                   => '',
						'pad_counts'               => false 
					
					); 
	
					$categories = get_categories($args); 
					foreach ($categories as $category) {
						$selected='';
						if(isset($query_taxonomies['pw_'.$tax]) && is_array($query_taxonomies['pw_'.$tax]))
						{
							$selected=(in_array($category->cat_ID,$query_taxonomies['pw_'.$tax]) ? "SELECTED":"");
						}
						
						$option = '<option value="'.$category->cat_ID.'" '.$selected.'>';
						$option .= $category->cat_name;
						$option .= ' ('.$category->category_count.')';
						$option .= '</option>';
						$param_line .= $option;
					}
					$param_line .= '</select>
				</div>';	
			}
			}
			
			//CREATE INDIVIDUAL SELECT BOX
			$pw_post_id='';
			$args_post = array('post_type' => $post_name,'posts_per_page'=>-1);
			$loop_post = new WP_Query( $args_post );
			$option_data.='<optgroup label="'.$post_name.'">';
			while ( $loop_post->have_posts() ) : $loop_post->the_post();
				$selected='';
				if(is_array($pw_post_id))
				{
					$selected=(in_array(get_the_ID(),$pw_post_id) ? "SELECTED":"");
				}
				$option_data.='<option '.$selected.' value="'.get_the_ID().'">'.get_the_title().'</option>';
			endwhile;
			$option_data.='</optgroup>';
		}
		
		if($option_data!=''){
			$param_line .='<div style=" text-transform:uppercase;border-bottom:2px solid #333;width:100%;margin:20px 0px">Individual Id(s)</div>';
			$param_line .='
				<select name="pw_post_id[]" style="width: 531px;" class="chosen-select" multiple="multiple" data-placeholder="'.__('Choose Properties ...',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' ..." id="pw_post_id">';
					$param_line.= $option_data.'
				</select>
			';	
		}
		
		echo $param_line;
		wp_die();
	}
	
	
	add_action('wp_ajax_pw_woo_ad_search_preset_frontend', 'pw_woo_ad_search_preset_frontend');
	add_action('wp_ajax_nopriv_pw_woo_ad_search_preset_frontend', 'pw_woo_ad_search_preset_frontend');
	function pw_woo_ad_search_preset_frontend(){
		global $pw_woo_ad_main_class;
		
		$xml_filename=$_POST['xml_filename'];
		
		if($_POST['source_type']=='from_xml'){
			$xml=simplexml_load_file(__PW_ROOT_WOO_AD_SEARCH__."/assets/demo-preset/".$xml_filename) or die("Error: Cannot create object");
			
			$xml_result=array();
			foreach($xml->postmeta as $xml_data){
				if($pw_woo_ad_main_class->isSerialized($xml_data->meta_value))
				{
					$xml_result["{$xml_data->meta_key}"]=unserialize($xml_data->meta_value); 
				}else{
					$xml_result["{$xml_data->meta_key}"]="{$xml_data->meta_value}"; 
				}
			}
			//print_r($xml_result);
			//echo json_encode($xml_result);
			wp_send_json($xml_result);
		}else{
			
			$post_id=$_POST['xml_filename'];
			
			$xml=simplexml_load_file(__PW_ROOT_WOO_AD_SEARCH__."/assets/demo-preset/demo_list_1.xml") or die("Error: Cannot create object");
			
			$xml_result=array();
			foreach($xml->postmeta as $xml_data){
				
				if($xml_data->meta_key!='')
				{
					$meta_value=get_post_meta($post_id, trim($xml_data->meta_key) , true);
					
					if(is_array($meta_value))
						$meta_value=serialize($meta_value);
					
					if($pw_woo_ad_main_class->isSerialized($meta_value) )
					{
						$xml_result["{$xml_data->meta_key}"]=unserialize($meta_value); 
					}else{
						$xml_result["{$xml_data->meta_key}"]="{$meta_value}"; 
					}
				}
			}
			//print_r($xml_result);
			wp_send_json($xml_result);
		}
		
		wp_die();
	}
	
	add_action('wp_ajax_pw_woo_ad_search_preset_frontend_delete', 'pw_woo_ad_search_preset_frontend_delete');
	add_action('wp_ajax_nopriv_pw_woo_ad_search_preset_frontend_delete', 'pw_woo_ad_search_preset_frontend_delete');
	function pw_woo_ad_search_preset_frontend_delete(){
		$post_id=$_POST['post_id'];
		$current_id=$_POST['current_id'];
		delete_post_meta($post_id, __PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'save_preset');
		if($current_id==$post_id)
			echo 'UNCHECK';
		wp_die();
	}
	
	//ADD PROPERTY TO FAVORITS
	add_action('wp_ajax_pw_woo_ad_sesarch_add_to_favorit', 'pw_woo_ad_sesarch_add_to_favorit');
	add_action('wp_ajax_nopriv_pw_woo_ad_sesarch_add_to_favorit', 'pw_woo_ad_sesarch_add_to_favorit');
	function pw_woo_ad_sesarch_add_to_favorit() {
		global $pw_woo_ad_main_class;
		extract($_POST);
		$pw_woo_ad_search_favorit_cookie='';
		if($favorite_status=='pw-woo-ad-search-favorite')
		{
			if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
			{
				//Remove From Favorite
				$pw_woo_ad_search_favorit_cookie=str_replace($post_id.',','',$_COOKIE['pw_woo_ad_search_favorit_cookie']);
				setcookie("pw_woo_ad_search_favorit_cookie", $pw_woo_ad_search_favorit_cookie, time()+3600, COOKIEPATH, COOKIE_DOMAIN);
			}else
			{
				setcookie("pw_woo_ad_search_favorit_cookie", '', time()+3600, COOKIEPATH, COOKIE_DOMAIN);
				$pw_woo_ad_search_favorit_cookie='';
			}
			
		}else
		{
			//Add To Favorite
			if(isset($_COOKIE['pw_woo_ad_search_favorit_cookie']))
			{
				$pw_woo_ad_search_favorit_cookie=$_COOKIE['pw_woo_ad_search_favorit_cookie'].$post_id.',';
				setcookie("pw_woo_ad_search_favorit_cookie", $pw_woo_ad_search_favorit_cookie, time()+3600, COOKIEPATH, COOKIE_DOMAIN);
			}else
			{
				setcookie("pw_woo_ad_search_favorit_cookie", $post_id.',', time()+3600, COOKIEPATH, COOKIE_DOMAIN);
				$pw_woo_ad_search_favorit_cookie=$post_id.',';
			}
		}
		
		$output='';
		$fav_count='';
		if($pw_woo_ad_search_favorit_cookie)
		{
			$your_favorites = $pw_woo_ad_search_favorit_cookie;
			$your_favorites = explode( ',' , $your_favorites );
			$favorite_count=count($your_favorites)-1;
			$fav_count=($favorite_count);
			$query_by_id_in=array();
			foreach($your_favorites as $ids)
			{
				$query_by_id_in[]=$ids;
			}
			
			$ars=array(
					'post_type' =>'product',
					'post_status'=>'publish',
					'post__in'=>$query_by_id_in,
				);
			$favorite_post = new WP_Query($ars);
			$output .='<ul id="favorite_div_items" class="woo-bxslider woo-single-car  woo-carousel-layout ">';
			while ( $favorite_post->have_posts() ) : $favorite_post->the_post(); 
				$fetch_post_id=get_the_ID();
				require __PW_ROOT_WOO_AD_SEARCH__.'/includes/content-favorite.php';
			endwhile;
			wp_reset_query();
			$output.='</ul>';
		}else
		{
			$output.=$pw_woo_ad_main_class->alert('error',__('No Favorites Has Been Added!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__));
		}
		echo $fav_count.'@'.$output;
		
		//echo ($_COOKIE['pw_woo_ad_search_favorit_cookie']);
		wp_die();
	}
	
	
	add_action('wp_ajax_pw_woo_ad_search_action_build_query_sql_result', 'pw_woo_ad_search_action_build_query_sql_result');
	add_action('wp_ajax_nopriv_pw_woo_ad_search_action_build_query_sql_result', 'pw_woo_ad_search_action_build_query_sql_result');
	function pw_woo_ad_search_action_build_query_sql_result() {
		global $wpdb,$pw_woo_ad_main_class;
		
	
		$return_value=$pw_woo_ad_main_class->build_search_query($_POST);
		
		$post = new WP_Query($return_value['query']);

		//PAGINATION OPTIONS
		$all_page_number=$post->max_num_pages;
		extract($_POST);
		
		//print_r($_POST);
		
		$pw_sf_pagination_type=isset($_POST['pw_sf_pagination_type']) ? $_POST['pw_sf_pagination_type']:'pagination_no';
		$pw_sf_pagination_paged=isset($_POST['pw_sf_pagination_paged']) ? $_POST['pw_sf_pagination_paged']:'1';
		
		$pw_sf_part=isset($_POST['pw_sf_part']) ? $_POST['pw_sf_part']:'';
		
		
		switch($pw_sf_part)
		{
			case "pw_woo_ad_grid_search":
			{
				$my_query = new WP_Query($return_value['query']);
				//print_r($return_value['query']);
				//echo $my_query->request;
				$pw_woo_ad_main_class->fetch_custom_fields($pw_sf_shortcode_id);
				$shortcode_id=$pw_sf_shortcode_id;
				
				
				if( $my_query->have_posts()):
					require __PW_ROOT_WOO_AD_SEARCH__.'/frontend/content-product.php';
				else :
					echo $pw_woo_ad_main_class->alert('error',__('No results were found. Please try a different search!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__));	
				endif;	
				
				if(!isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']))
				{
					require('actions_pagination.php');
					echo $pagination;
				}
			}
			break;
			
			case "pw_woo_ad_grid":
			{
				$my_query = new WP_Query($return_value['query']);
				//echo $my_query->request;
				$pw_woo_ad_main_class->fetch_custom_fields($pw_sf_shortcode_id);
				$shortcode_id=$pw_sf_shortcode_id;
				
				
				if( $my_query->have_posts()):
					require __PW_ROOT_WOO_AD_SEARCH__.'/frontend/content-product.php';
				else :
					echo $pw_woo_ad_main_class->alert('error',__('No results were found. Please try a different search!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__));	
				endif;	
				
				if(!isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'enable_carousel']))
				{
					require('actions_pagination.php');
					echo $pagination;
				}
			}
			break;
			
			case "pw_woo_ad_grid_archive_page":
			{
				$products = new WP_Query($return_value['query']);
				 $woocommerce_loop['columns'] = 4;
			
				if ( $products->have_posts() ) : ?>
			
						<?php woocommerce_product_loop_start(); ?>
			
							<?php while ( $products->have_posts() ) : $products->the_post(); ?>
			
								<?php wc_get_template_part( 'content', 'product' ); ?>
			
							<?php endwhile; // end of the loop. ?>
			
						<?php woocommerce_product_loop_end(); ?>
			
					<?php endif;
			
				wp_reset_postdata();
			
				echo '<div class="woocommerce columns-4">' . ob_get_clean() . '</div>';
			}
			break;
			
		}
		
		echo '@'.implode(' ',$return_value['your_search']);
		wp_die();
	}
	
	
	add_action('wp_ajax_pw_woo_ad_sesarch_sendto_form', 'pw_woo_ad_sesarch_sendto_form');
	add_action('wp_ajax_nopriv_pw_woo_ad_sesarch_sendto_form', 'pw_woo_ad_sesarch_sendto_form');
	function pw_woo_ad_sesarch_sendto_form() {
		global $pw_woo_ad_main_class,$wpdb;
		
		if(isset($_POST['post_id'])){
			$sendto_fields=(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_fields')=='' ? '':get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_fields'));
			
			$form_fields=$pw_woo_ad_main_class->alert('error',__('There are any fields for "Send To" form. Please set it in setting!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__));	
			
			if($sendto_fields!=''){
				$form_fields='<form id="pw_woo_ad_search_sendto_form">
					<div id="pw-ad-woo-search-sendto-result"></div>
				';
				foreach($sendto_fields as $fields){
					
					if($fields=='address' || $fields=='description'){
						$form_fields.='
						<div class="woo-col-md-12">
							<div class="input-group input-group-sm">
								<textarea cols="34" rows="5" class="form-control textarea-input search-field" name="'.$fields.'" placeholder="'.__(ucwords($fields),__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'"></textarea>
							</div>
						</div>';
					}else{
						
						$required='';
						$type='search';
						if($fields=='email')
						{
							$required='required';
						}
						
						if($fields=='email')
						{
							$required='required';
							$type='email';
						}
						
						$form_fields.='
						
						<div class="woo-col-md-12">
							<div class="input-group input-group-sm">
									<input type="'.$type.'"  '.$required.'  name="'.$fields.'" class="form-control title-input search-field" value="" placeholder="'.__(ucwords($fields),__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'" data-searchfied="Keywords">
							</div>
						</div>';
					}
				}
				
				$form_fields.='
					<div class="woo-col-md-12">
						<div class="input-group input-group-sm">
							<input type="hidden" name="id_post"  value="'.$_POST['post_id'].'" />
							<input type="hidden" name="post_hidden"  value="Y" />
							<input type="submit" class="search-submit" value="'.__('Send',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).'">
						</div>
					</div>
					</form>
				';
			}
			
		
			echo '
						        
				<div class="woo-sendto-title">
					<h3>'.(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title')=='' ? __('Send Product Form',__PW_WOO_AD_SEARCH_TEXTDOMAIN__) : get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_title')).'</h3>
				</div>	
				
				<div id="woo-row">
					'.$form_fields.'
				</div>
			';
			
		}else{
			
			extract($_POST);
			
			$post_type='product';
			$args=array('post_type' => $post_type,
						'post_status'=>'publish',
						'post__in'=>array($id_post),
					 );
			
			$product_name='';
			$product_link='';
			$sendto_post = new WP_Query($args);		 
			if( $sendto_post->have_posts()):
				while ( $sendto_post->have_posts() ) : $sendto_post->the_post(); 
					$product = get_product($sendto_post->post->ID);
					$product_name = $product->get_title();
					$product_link=$product->get_permalink();
					$product_price = $product->get_price_html();
					
					$thumbnail_id = $product->get_image_id();
					$img_url_thumb = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
					$img_url_thumb=$img_url_thumb[0];
					
					$product_desc = $product->post->post_excerpt;
					if($product_desc=='')
						$product_desc = $product->post->post_content;
					
				endwhile;
				wp_reset_query();
			endif;	
			
			$from = (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_receiver_email')=='' ? get_option('admin_email'):get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_receiver_email'));
			
			$to=$email;
	
			$subject = __( 'Suggest Product :: ' , __PW_WOO_AD_SEARCH_TEXTDOMAIN__ );
			$headers = __('From: ',__PW_WOO_AD_SEARCH_TEXTDOMAIN__). $from . "\r\n" .
			'Reply-To: ' . $from . "\r\n";
						
			$html='
				<div style="display:inline-block; width:92%;background:#ffffff; border:4px dashed #ccc; padding:20px; background:#f5f5f5;">
					<div style="font-family:Arial,Tahoma; font-size:30px; margin-bottom:10px; font-weight:bold;" >
						<span>'.__('Dear',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </span>
						<span style="color:red;">'.(isset($name_to) ? $name_to:'').'</span>, 
					</div>
					<div style="font-family:Arial,Tahoma; font-size:20px;margin-bottom:10px;" >
						<span>'.__('Your friend',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' <span style="color:red;">'.(isset($name_from) ? $name_from:'').', </span> '.__('has been invited you to see this product',__PW_WOO_AD_SEARCH_TEXTDOMAIN__).' </span>
					</div>
					<div style="font-family:Arial,Tahoma; font-size:20px;margin-bottom:10px;" >
						<span>'.(isset($description) ? $description:'').'</span>
					</div>
					<div style="margin-top:20px;">
						<div style="float:left; width:100px; height:140px; margin-right:10px; padding: 5px 5px 3px 5px;background: #ccc;">
							<img src="'.$img_url_thumb.'" width="100" height="140" >
						</div>
						<div style="font-weight:bold; color:red; font-size:15px; margin-bottom:10px" ><a href="'.$product_link.'" target="_blank">'.$product_name.'</a></div>
						<div style="font-size:13px;margin-bottom:10px" >'.do_shortcode($product_desc).'</div>
						<div style="font-weight:bold; color:red; font-size:15px;" >'.(isset($product_price) ? $product_price:__('No Price!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)).'</div>
					</div>
				</div>
				';
	
			add_filter( 'wp_mail_content_type', 'pw_woo_ad_grid_set_html_content_type' );  
			$sent = wp_mail($to, $subject, $html, $headers);
			remove_filter( 'wp_mail_content_type', 'pw_woo_ad_grid_set_html_content_type' );
									
			if (isset($sent) && count($sent)) {
				echo '<div class="woo-col-md-12">
						<div class="input-group input-group-sm">'.$pw_woo_ad_main_class->alert('success',__('Thanks, Your message has been sent.',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)).'</div>
					</div>';
						
							
			} 
			else
			{
				echo '<div class="woo-col-md-12">
					<div class="input-group input-group-sm">'.$pw_woo_ad_main_class->alert('error',__('Error, Please Try Again!',__PW_WOO_AD_SEARCH_TEXTDOMAIN__)).'</div>
				 </div>';
			}
		}
		
		wp_die();
	}
	function pw_woo_ad_grid_set_html_content_type() {
		return 'text/html';
	}
	
	add_action('wp_ajax_pw_woo_ad_sesarch_quickview', 'pw_woo_ad_sesarch_quickview');
	add_action('wp_ajax_nopriv_pw_woo_ad_sesarch_quickview', 'pw_woo_ad_sesarch_quickview');
	function pw_woo_ad_sesarch_quickview() {
		global $wpdb,$pw_woo_ad_main_class,$post,$woocommerce;
		
		// woocommerce_get_template( 'single-product.php' );
		
		$product_id=$_POST['post_id'];
		$id=$_POST['post_id'];
		
		$product = get_product($product_id);
		
		$title = $product->get_title();
		$excerpt = $product->post->post_excerpt ;
		$postd = get_post($id);
	//	echo $excerpt.'<br/>';
	//	echo $id.'<br/>';
		//print_r($post);
	//	$postd->post_excerpt;
	//	echo '<br/>'.$postd->post_excerpt;
		$thumbnail_id = $product->get_image_id();
		
		$src_featured = wp_get_attachment_image( $thumbnail_id, 'thumbnail'); //Featured Image with size
		
		$img=$product->get_image(); //Featured Image 
 
 		$permalink=$product->get_permalink();
		$add_to_cart_url = $product->add_to_cart_url();
		
		$regular_price = $product->get_regular_price();
		$sale_price = $product->get_sale_price();
		$price = $product->get_price_html();
		
		//$rating = $product->get_rating_html();				
		$rating=pw_woo_ad_search_rating_grid($id);
		$cat =$product->get_categories();				
		$tag =$product->get_tags();
		$sku =$product->get_sku();
		$stock_status =$product->is_in_stock(); //1 : in ,0 :out
		$stock_quantity =$product->get_stock_quantity();
		
		$featured =$product->is_featured();
		$on_sale =$product->is_on_sale(); // 1:0
		
		$thumb_index=0;
		$product_thumb=$product_slide='';
		$img_url=array();
		$img_url_default='';
		
		if($product->get_image_id() != NULL ){
			$img_url = wp_get_attachment_image_src( $product->get_image_id(), 'large' );
			$img_url_thumb = wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' );
			$product_slide .='<li><div class="thumb-divback thumb-1-2" style="background:url('. $img_url[0].') no-repeat; overflow: hidden;background-position: 50% 50%!important;background-size: cover!important;" ></div></li>';
			$product_thumb .='<a data-slide-index="'.$thumb_index++.'" href=""><img src="'. $img_url_thumb[0].'" /></a>';
		}
		$this_product_gallery = $product->get_gallery_attachment_ids();
		if( $this_product_gallery != NULL){
			foreach ($this_product_gallery as $this_image){
				$img_url = wp_get_attachment_image_src( $this_image, 'large' );
				$img_url_thumb = wp_get_attachment_image_src( $this_image, 'thumbnail' );
				$product_slide .='<li><div class="thumb-divback thumb-1-2" style="background:url('. $img_url[0].') no-repeat; overflow: hidden;background-position: 50% 50%!important;background-size: cover!important;" ></div></li>';
				$product_thumb .='<a data-slide-index="'.$thumb_index++.'" href=""><img src="'. $img_url_thumb[0].'" /></a>';
			}
		}
		if($product->get_image_id() == NULL && $this_product_gallery == NULL ){
			$img_url_default = wc_placeholder_img_src();
		}
		
		$result='';
		$add_to_cart_btn ='';
		$add_to_cart_label=pw_woo_ad_search_add_to_cart_grid('btn_text_type',$id);
		if( $product->is_type( 'simple' ) ){
			$add_to_cart_btn = "<div class='woo-addcard-btn  back-btn'>".$add_to_cart_label."</div>";
		}
		elseif( $product->is_type( 'variable' ) ){
			//global $product, $post;
			//$product = $product;
			//$post = get_post($id);
			//require( __PW_ROOT_WOO_AD_SEARCH__. '/add_to_cart/variable.php' );
			$add_to_cart_btn = "<div class='woo-addcard-btn  back-btn'>".$add_to_cart_label."</div>";
		}
		else{
			$add_to_cart_btn = "<div class='woo-addcard-btn  back-btn'>".$add_to_cart_label."</div>";
		}
		echo '<div class="woo-row">';
			echo '<div class="woo-col-md-7 woo-quick-image-cnt">
					<ul id="woo-quick-car" class="woo-quick-car woo-bxslider woo-single-car  woo-carousel-layout">'.$product_slide.'</ul>
					<div id="woo-pager" class="woo-pager">
					'.$product_thumb.'
					</div>
				  </div>';
			echo '<div class="woo-col-md-5">
					<div class="woo-quick-detail-cnt">';

				//Start Of Scroll
				
								
				echo '<h3 class="woo-quick-title"><a href="'.$permalink.'" >'.$title.'</a></h3>';
				echo '<div class="woo-quick-rating">'.$rating.'</div>';
				
				echo '<div class="woo-quick-price"><span class="woo-quick-sale-price">' .$price.'</div>';
				echo '<div class="woo-quick-excerpt">'.do_shortcode($excerpt).'</div>';
				
				print_r('<div class="woo-quick-cat">'.$cat.'</div>');
				print_r('<div class="woo-quick-tag">'.$tag.'</div>');
				echo $result;
				echo '<div class="woo-quick-add add_to_cart_button product_type_simple add-to-cart" data-product_id="'.$id.'" data-quantity="1">'.$add_to_cart_btn.'</div>';
				
				
			echo '	</div>
				</div>';
		echo '</div>';
		
		wp_die();
	}
	function pw_woo_ad_search_frontend_add_scripts_popup(){
		
	}
?>