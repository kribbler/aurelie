<?php
	class pw_woo_ad_Widget extends WP_Widget {
	
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'pw-woo-ad-Widget', // Base ID
				__('WooCommerce Magic Grid', __PW_WOO_AD_SEARCH_TEXTDOMAIN__), // Name
				array( 'description' => __( 'Create Advanced Search Widgets with Magic Search/Grid Shortcodes.', __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ), ) // Args
			);
		}
	
		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			
			global $pw_woo_ad_main_class;
			$id=$instance['search_widget'];
			$pw_woo_ad_main_class->fetch_custom_fields($id);
			//CHEK ALL ON_OFF VARIABLE (DEFAULT VALUE)
			$pw_sf_post_type=$pw_woo_ad_main_class->custom_field[__PW_WOO_AD_SEARCH_FIELDS_PERFIX__ . 'post_type'];
		
			$pw_sf_shortcode_id=$id;
			
			$pw_sf_part='pw_woo_ad_grid_widget';
			
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
			
			$argss=array(
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
			
			echo $pw_woo_ad_main_class->build_search_form_html($argss);
			
			//echo '<div class="row " id="'.$pw_sf_target_element_id.'"></div>';
			
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
			
			
			echo '<div class="loading-cnt loadd" style="background:'.$loading_color.'"><div class="le-loading" >'.$loading_content.'</div></div>';

				
			echo $args['after_widget'];
		}
	
		public function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
				
			<p><label for="<?php echo $this->get_field_id('show'); ?>"><?php _e('Choose Shortcode : ',__PW_WOO_AD_SEARCH_TEXTDOMAIN__); ?></label>
				<select class='widefat' id="<?php echo $this->get_field_id('search_widget'); ?>"
						name="<?php echo $this->get_field_name('search_widget'); ?>" type="text">
                  		<option ><?php echo __('Choose Shortcode',__PW_WOO_AD_SEARCH_TEXTDOMAIN__);?></option>      
                  <?php
						global $pw_woo_ad_main_class,$wpdb;
						
						$query_meta_query=array('relation' => 'AND');
						$query_meta_query[] = array(
									'key' => __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type',
									'value' => "search_grid_widget",
									'compare' => '=',
								);
						
						$args=array('post_type' => 'ad_woo_search_grid',
						'post_status'=>'publish',
						'meta_query' => $query_meta_query,
						);
						
						$my_query_archive = new WP_Query($args);
						
						if( $my_query_archive->have_posts()):
							while ( $my_query_archive->have_posts() ) : $my_query_archive->the_post(); 	
								$id=get_the_ID();
								echo '<option value="'.$id.'" '.selected($id,$instance['search_widget'],1).'>'.get_the_title().'</option>';
							endwhile;
						endif;	

				  ?>
				</select>
			</p>
			<?php 
		}
	
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['search_widget'] = $new_instance['search_widget'];		
			
			return $instance;
		}
	}

	register_widget( 'pw_woo_ad_Widget' );

?>