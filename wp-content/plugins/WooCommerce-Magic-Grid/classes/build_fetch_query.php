<?php
	global $pw_woo_ad_main_class,$wpdb;

	$pw_post_type=$pw_post_per_page=$pw_order_by=$pw_price_type=$pw_order=$pw_post_id='';

	//Query Variable
	$query_post_type=$query_posts_per_page=$query_meta_key=$query_orderby=$query_order=$paged=$query_by_id_in=$query_by_id_not_in=$query_tax_query='';
	
	$query_posts_per_page=10;
	$query_post_type='product';
	$query_meta_key='';
	$query_orderby='date';
	$query_order='ASC';

	
	$build_query_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'fetch_type'];
	$query_meta_query=array('relation' => 'AND');
	switch($build_query_type)
	{
		case "build_query":
		{
			$pw_query=$this->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'build_query_taxonomy','custom_field','');
			
			if(isset($pw_query['taxonomy_checkbox'])){				
				$query_tax_query=array('relation' => 'AND');
				$taxonomies=$pw_query['taxonomy_checkbox'];
				foreach($taxonomies as $taxonomy){
					if(isset($pw_query['in_'.$taxonomy]))
					{
						$taxonomy_value=$pw_query['in_'.$taxonomy];
						$query_tax_query[]=array(
							'taxonomy' => $taxonomy,
							'field'    => 'id',
							'terms'    => $taxonomy_value,
							'operator' => 'IN',
						);
					}
					
					if(isset($pw_query['ex_'.$taxonomy]))
					{
						$taxonomy_value=$pw_query['ex_'.$taxonomy];
						$query_tax_query[]=array(
							'taxonomy' => $taxonomy,
							'field'    => 'id',
							'terms'    => $taxonomy_value,
							'operator' => 'Not IN',
						);
					}
				}
			}
			
			$query_by_id_in='';
			if(isset($pw_query['in_ids'])){
				$query_by_id_in=$pw_query['in_ids'];
			}
			
			$query_by_id_not_in='';
			if(isset($pw_query['ex_ids'])){
				$query_by_id_not_in=$pw_query['ex_ids'];
			}
		}
		break;
		
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
					)
			;
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
		   'key' => '_regular_price',
		   'value' => '',
		   'compare' => '!='
		 );
	}
	/*$query_posts_per_page=$query_second_part_value;
	if(strtolower($query_posts_per_page)=='all')
		$query_posts_per_page="-1";*/
	$query_posts_per_page="-1";
	
	
	if(isset($pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'hide_recent_post'])){
		
		$query_posts_recent=$pw_woo_ad_main_class->check_isset(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'hide_recent_post_num','custom_field','1');
		
		$query_final=array('post_type' => $query_post_type,
			'post_status'=>'publish',
			'posts_per_page'=>$query_posts_recent,
			'orderby' => 'date',
			'order' => 'DESC',
			'paged'=>$paged,
			
			'post__in'=>$query_by_id_in,
			'post__not_in'=>$query_by_id_not_in,
			
			'meta_query' => $query_meta_query,
			'tax_query'=>$query_tax_query
		);
		
		$my_query = new WP_Query($query_final);	
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
	
	$query_final=array('post_type' => $query_post_type,
		'post_status'=>'publish',
		'posts_per_page'=>$query_posts_per_page,
		'meta_key' => $query_meta_key,
		'orderby' => $query_orderby,
		'order' => $query_order,
		'paged'=>$paged,
			
		'post__in'=>$query_by_id_in,
		'post__not_in'=>$query_by_id_not_in,
		
		'meta_query' => $query_meta_query,
		'tax_query'=>$query_tax_query
	);
	 
	//die(print_r($query_final));
	
	$my_query = new WP_Query($query_final);
?>