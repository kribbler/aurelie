<?php
	
	include('actions.php');

	add_action( 'admin_head', 'pw_woo_ad_search_admin_add_scripts' );	
	function pw_woo_ad_search_admin_add_scripts(){
		
		//////////BOOTSTRAP//////////
		
		//FONTAWESOME STYLE //font-awesome-css
		wp_register_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'font-awesome-ccc', __PW_WOO_AD_SEARCH_CSS__.'font-awesome.css',true);
		wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'font-awesome-ccc');
		
		/////////ADMIN STYLE/////////////////
		wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'admin-style',__PW_WOO_AD_SEARCH_CSS__.'admin-style.css',true);
		
		/////////LightBox/////////////////
		wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'lightbox-style',__PW_WOO_AD_SEARCH_CSS__.'lightbox/lightbox.css',true);
		
		/////////////////////////CSS CHOSEN///////////////////////
		wp_register_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_css_1', __PW_WOO_AD_SEARCH_CSS__.'chosen/chosen.css', false, '1.0.0' );
		wp_enqueue_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_css_1' );
		
		/////////////////////////CSS FORM STEP WIZARD///////////////////////
		wp_register_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'form-step-css', __PW_WOO_AD_SEARCH_CSS__.'back-end/form-step/jquery.steps.css', false, '1.0.0' );
		wp_enqueue_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'form-step-css' );
			
		
		/////COLOR PICKKER//////
		wp_enqueue_style( 'wp-color-picker' );
		
		/////JS ENQUEUE////////////
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('wp-color-picker');
		
		//FOR UPLOAD FILE IN TAXONOMY
		if(function_exists( 'wp_enqueue_media' )){
		    wp_enqueue_media();
		}else{
		    wp_enqueue_style('thickbox');
		    wp_enqueue_script('media-upload');
		    wp_enqueue_script('thickbox');
		}
		
		//////////////////CHOSEN//////////////////////////
		wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_js1', __PW_WOO_AD_SEARCH_JS__.'back-end/chosen/chosen.jquery.min.js' , false, '1.0.0' );
		wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_js1' );
		
		
		//////////////////DEPENDENCY//////////////////////////
		global $post_type;
   		if( 'ad_woo_search_grid' == $post_type || (isset($_GET['post_type']) && 'ad_woo_search_grid' == $_GET['post_type']) )
		{
			wp_register_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'dependency', __PW_WOO_AD_SEARCH_JS__.'back-end/dependency/dependsOn-1.0.1.min.js' , false, '1.0.0' );
			wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'dependency' );
		}
		
		//////////////////CUSTOM JS//////////////////////////
		wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'custom_js', __PW_WOO_AD_SEARCH_JS__.'back-end/custom-js.js' , false, '1.0.0' );
		
		/////////////////LIGHTBOX JS//////////////////////////
		wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'lightbox', __PW_WOO_AD_SEARCH_JS__.'back-end/lightbox/lightbox-2.6.min.js' , false, '2.6.0' );
		
		/////////////////FORM STEP WIZARD JS//////////////////////////
		wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'form-step-js', __PW_WOO_AD_SEARCH_JS__.'back-end/form-step/jquery.steps.js' , false, '2.6.0' );
		
		
		//////////////OTHER SCRIPTS/////////////
		global $post_type;
   		if( 'ad_woo_search_grid' == $post_type )
		{
			$output='
				<script type="text/javascript">
					jQuery(document).ready(function(jQuery){
						
						
						if(jQuery("html").find("#ad_search_grid_build_query").length)
						{
							jQuery("#ad_search_grid_layout_setting").dependsOn({
								"#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type": {
									not: [\'search_grid_widget\']
								}
							});
							
							setTimeout(function(){
								jQuery(".'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_pagination_field").dependsOn({
									"#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type": {
										not: [\'search_grid_widget\']
									}
								});
								
								jQuery(".'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'pagination_show_more_type_field").dependsOn({
									"#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type": {
										not: [\'search_grid_widget\']
									}
								});
								
								jQuery(".'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'pagination_show_more_color_set_field").dependsOn({
									"#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type": {
										not: [\'search_grid_widget\']
									}
								});
								
								jQuery(".'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'post_per_page_field").dependsOn({
									"#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type": {
										not: [\'search_grid_widget\']
									}
								});
								
								jQuery(".'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_column_desktop_field").dependsOn({
									"#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type": {
										not: [\'search_grid_widget\']
									}
								});
								
								jQuery(".'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_column_tablet_field").dependsOn({
									"#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type": {
										not: [\'search_grid_widget\']
									}
								});
								
								jQuery(".'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search_column_mobile_field").dependsOn({
									"#'.__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'shortcode_type": {
										not: [\'search_grid_widget\']
									}
								});
								
							},500);

						}
					})
				</script>';	
			echo $output;			
		}

		if(!function_exists('pw_woo_ad_search_dependency'))
		{
			function pw_woo_ad_search_dependency($element_id,$args)
			{
				$output='';
				$output.='
				<script type="text/javascript">
					jQuery(document).ready(function(jQuery){
					
					jQuery("."+"'.$element_id.'_field").dependsOn({';		
						foreach($args['parent_id'] as $parent)
						{
							$element_type=$args[$parent][0];
							unset($args[$parent][0]);
							switch($element_type)
							{
								case "select":
								{
									$output.= '
									"#'.$parent.'": {
											values: [\''.(is_array($args[$parent]) ? implode("','", $args[$parent]) : $args[$parent]).'\']
									},';
								}
								break;
								
								case "checkbox":
								{
									if($args[$parent])
										$output.= '
										"#'.$parent.'": {
											checked: true
										},';
									else
										$output.= '
										"#'.$parent.'": {
											checked: false
										},';
	
								}
								break;
							}
						}
				$output.='
						});
					});
				 </script>';
				 return $output;
			}
		}
	}
?>