<?php
/*
Plugin Name: WooCommerce Magic Grid
Plugin URI: http://proword.net/woogrid/
Author: Proword
Author URI: http://proword.net/
Version: 4.0
Description: Create unlimited advanced beautiful grids & lists with professional custom ajax filters , search and sort.
Text Domain: pw_woo_woo_ad_search_grid
*/

if(!defined('__PW_ROOT_WOO_AD_SEARCH__')){
	define('plugin_dir_url_pw_woo_ad_search', plugin_dir_url( __FILE__ ));
	define( '__PW_ROOT_WOO_AD_SEARCH__', dirname(__FILE__));
	define( '__PW_WOO_AD_SEARCH_CSS__', plugins_url('assets/css/',__FILE__));
	define( '__PW_WOO_AD_SEARCH_JS__', plugins_url('assets/js/',__FILE__));
	define ('__PW_WOO_AD_SEARCH_URL__',plugins_url('', __FILE__));
	define ('__PW_WOO_AD_SEARCH_FIELDS_PERFIX__', 'custom_' );
	define ('__PW_WOO_AD_SEARCH_TEXTDOMAIN__', 'pw_woo_woo_ad_search_grid' );
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if(!class_exists('PW_WOO_AD_SEARCH'))
	{
		require_once('classes/customepost.php');
		require_once('classes/customefields.php');
		require_once ('classes/func.php');
		require_once ('includes/shortcode/main.php');
		
		//SEARCH FRAMEWORK
		require_once __PW_ROOT_WOO_AD_SEARCH__.'/classes/search_framework/search_framework.php';
		
		//add_action('init','pw_general_grid_admin_init');
		function pw_general_grid_admin_init(){
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			
			//remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
			//remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
			//remove_action( 'woocommerce_after_main_content', 'woocommerce_result_count', 20 );
		}
		
		class PW_WOO_AD_SEARCH extends PW_SEARCH_FRAMEWORK
		{
			public $custom_field=array();
			var $module_dir;
			function __construct()
			{
				
				register_activation_hook( __FILE__ , array( $this, 'on_activation' ) );
				
				/////ALWAYS PUT IN FIRST ACTION INIT/////
				add_action('init', array ( $this , 'set_newuser_cookie' ) );
				///////////////
				
				add_action('init',array($this,'pw_general_grid_admin_init'));
				add_action('init',array($this,'frontend_init'));
				
				add_action('wp_footer', array($this,'add_to_footer'));
				
				//Widget Register
				add_action( 'widgets_init', array( $this, 'include_widgets' ) );
				
				//ADD TITLE SEARCH
				add_filter( 'posts_where', array($this,'search_title_func'), 10, 2 );
	
				add_action('admin_menu', array($this,'pw_register_my_custom_submenu_page'));
				//add_filter('add_to_cart_redirect', array($this,'custom_add_to_cart_redirect'));
	
				
				//USE OUR STYLE AS DEFAULT THEME
				if ( get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."magic_page_use")== 'on') {
					add_action( 'template_redirect', array($this,'pw_redirect_page_template'),1 );	
					add_filter( 'term_link', array($this,'pw_convert_term_to_type'), 12, 3 );
					add_filter( 'the_title',array($this,'pw_page_title_change' ),10,2);	
					
				}
				//FOR ALL TAXONOMY	
				add_filter('query_vars', array($this,'parameter_queryvars') );	
				add_action( 'plugins_loaded', array( $this, 'loadTextDomain' ) );
			}	
			
			
			public function loadTextDomain() {
				load_plugin_textdomain( __PW_WOO_AD_SEARCH_TEXTDOMAIN__ , false, basename( dirname( __FILE__ ) ) . '/languages/' );
			}
			
			function parameter_queryvars( $qvars )
			{
				$qvars[] = 'pw_woo_taxonomy';
				return $qvars;
			}
			
			function pw_convert_term_to_type( $link, $term, $taxonomy ) {
				if ( $term->taxonomy=== 'product_cat' ) {
					
					$pw_woo_category_page=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."category_page");
					if($pw_woo_category_page!=''){
						$pw_woo_redirect_link = add_query_arg( array('product_cat'=>$term->slug,'pw_woo_page'=>1), get_permalink($pw_woo_category_page) );
						if ( !empty( $pw_woo_redirect_link ) ) return $pw_woo_redirect_link;
					}
				}
				if ( $term->taxonomy=== 'product_tag' ) {
					
					$pw_woo_page_tag=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."tag_page");
					if($pw_woo_page_tag!=''){
						$pw_woo_redirect_link = add_query_arg( array('product_tag'=>$term->slug,'pw_woo_page'=>1), get_permalink($pw_woo_page_tag) );
						if ( !empty( $pw_woo_redirect_link ) ) return $pw_woo_redirect_link;
					}
				}
				
				return $link;
			}
	
			
			function pw_redirect_page_template()
			{
				global $wp_query,$woocommerce,$wp,$_chosen_attributes;
			
				$pw_woo_post_type=$wp_query->query_vars['post_type'];
				$pw_woo_taxonomy=isset($wp_query->query_vars['taxonomy']) ? $wp_query->query_vars['taxonomy'] :'';
				$pw_woo_redirect_link='';
				
				if ($pw_woo_taxonomy === 'product_cat') {
					$pw_woo_category_page=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."category_page");
					if($pw_woo_category_page!=''){
						$pw_woo_query_args=array_merge( $wp_query->query, array( 'pw_woo_page' => 1 ) );
						$pw_woo_redirect_link = add_query_arg( $pw_woo_query_args, get_permalink($pw_woo_category_page) );
					}
				}elseif ( $pw_woo_post_type === 'product' && is_post_type_archive('product')&& !is_single() ) {
					$pw_woo_page_shop=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."shop_page");
					if($pw_woo_page_shop!=''){
						$pw_woo_query_args=array( 'pw_woo_page' => 1 );
						$pw_woo_redirect_link = add_query_arg( $pw_woo_query_args ,get_permalink($pw_woo_page_shop));
					}
				}elseif ( $pw_woo_taxonomy === 'product_tag' ) {
					$pw_woo_page_tag=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."tag_page");
					if($pw_woo_page_tag!=''){
						$pw_woo_query_args=array_merge( $wp_query->query, array( 'pw_woo_page' => 1 ) );
						$pw_woo_redirect_link = add_query_arg( $pw_woo_query_args, get_permalink($pw_woo_page_tag) );
					}
				}elseif(!empty($pw_woo_taxonomy)){
					$pw_woo_page_shop=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."taxonomy_page");
					if($pw_woo_page_shop!=''){
						$term = get_term_by( 'slug', get_query_var('term'), $pw_woo_taxonomy );
						$pw_sf_taxonomy_id=$term->term_id;
						$pw_woo_query_args=array_merge( $wp_query->query, array('pw_woo_taxonomy' => $pw_woo_taxonomy  ,'pw_woo_page' => 1) );
						$pw_woo_redirect_link = add_query_arg( $pw_woo_query_args ,get_permalink($pw_woo_page_shop));
					}
				}
				
				if($pw_woo_redirect_link){
					wp_redirect($pw_woo_redirect_link);
				}	
			}
			
			function pw_page_title_change($title, $id ){
				$pw_woo_is_admin=is_admin();
					if( ($id != get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."search_page")&&
						$id != get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."category_page")&&
						$id != get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."tag_page"))||
						$pw_woo_is_admin
						){ return $title;}
					if($id==get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."shop_page")){
						return $title;
					}elseif($id==$cat_id=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."category_page") ){
						$pw_woo_product_slug_category=get_query_var('product_cat');
						if(!empty($pw_woo_product_slug_category) && !is_array($pw_woo_product_slug_category))
						{
							$pw_woo_cat_name=get_term_by('slug', $pw_woo_product_slug_category, 'product_cat');
							return $pw_woo_cat_name->name;
						}else
							return $title;
					}elseif($id==$tag_id=get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."tag_page") ){
						$pw_woo_product_slug_tag=get_query_var('product_tag');
						if(!empty($pw_woo_product_slug_tag) && !is_array($pw_woo_product_slug_tag))
						{
							$pw_woo_tag_name=get_term_by('slug', $pw_woo_product_slug_tag, 'product_tag');
							return $pw_woo_tag_name->name;
						}else
							return $title;
					}elseif($id==get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__."search_page") ){
						return $title.' - '.(isset($_GET['pw_woo_page']) ? $_GET['pw_woo_page'] : "");
					}
			}
	
	
				
			function custom_add_to_cart_redirect() {
				 return get_permalink(get_option('woocommerce_cart_page_id'));
			}
	
			function set_newuser_cookie() 
			{
				
				if ( !is_admin() && !$this->is_login_page() && !isset($_COOKIE['pw_woo_ad_search_favorit_cookie'])) {
					setcookie("pw_woo_ad_search_favorit_cookie", '', time()+3600, COOKIEPATH, COOKIE_DOMAIN);
				}
				//setcookie("pw_woo_ad_search_favorit_cookie", '', time()-3600, COOKIEPATH, COOKIE_DOMAIN);
				
			}
			
			function show_before()
			{
				
			}
			
			public function before_products() {
				//require __PW_ROOT_WOO_AD_SEARCH__.'/frontend/search_archive_page.php';
				echo '<div class="pw-ad-codenegar-shop-loop-wrapper">';
			}
		
			public function after_products() {
				echo '</div>';
			}
		
			public function before_no_products($template_name = '', $template_path = '', $located = '') {
				if ($template_name == 'loop/no-products-found.php') {
					echo '<div class="pw-ad-codenegar-shop-loop-wrapper">';
				}
			}
		
			public function after_no_products($template_name = '', $template_path = '', $located = '') {
				if ($template_name == 'loop/no-products-found.php') {
					echo '</div>';
				}
			}
		
			public function before_pagination($template_name = '', $template_path = '', $located = '') {
				echo '<div class="pw-ad-codenegar-shop-pagination-wrapper">';
			}
		
			public function after_pagination($template_name = '', $template_path = '', $located = '') {
				echo '</div>';
			}
			
			
			function search_title_func( $where, &$wp_query )
			{
				global $wpdb;
				if ( $wpse18703_title = $wp_query->get( 'search_title' ) ) {
					$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $wpse18703_title ) ) . '%\'';
				}
				return $where;
			}
			
			function pw_register_my_custom_submenu_page(){
				//add_submenu_page('ad_woo_search_grid', "Search Setting" , "Search Setting" ,'activate_plugins', 'pw_woo_ad_search_setting' , array($this,'pw_woo_ad_search_setting'));
				add_submenu_page('edit.php?post_type=ad_woo_search_grid', __('Magic Grid Settings',__PW_WOO_AD_SEARCH_TEXTDOMAIN__), __('Magic Grid Settings',__PW_WOO_AD_SEARCH_TEXTDOMAIN__), 'manage_options', 'ad_woo_search_grid_setting', array($this,'pw_woo_ad_search_setting'));
			}
			
			function pw_woo_ad_search_setting(){
				include __PW_ROOT_WOO_AD_SEARCH__.'/classes/search-grid-options.php';
			}
			
			function pw_gt_admin_scripts()
			{
				wp_enqueue_style('pw_gt_font-awesome', __PW_WOO_AD_SEARCH_CSS__ .'fonts/font-awesome.css');
				wp_enqueue_style('pw_gt_font-awesome_style', __PW_WOO_AD_SEARCH_CSS__ .'fonts/style.css');			
				
			}
			
			function is_login_page() {
				return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
			}
			
			function pw_general_grid_admin_init()
			{
				
				// activate addons one by one from modules directory
				/*foreach(glob($this->module_dir."/*.php") as $module)
				{
					require_once($module);
				}*/
				require_once('includes/admin-embed.php');
				require_once('includes/taxonomy_attribute.php');
				
				
				//FAVORITE 
				if(!is_admin() && !$this->is_login_page()){
					add_shortcode('pw-woo-ad-search-grid', array($this,'pw_woo_ad_search_grid'));
					require_once(__PW_ROOT_WOO_AD_SEARCH__.'/includes/frontend-embed.php');
						
				}
				
			}// end aio_init		
			
			public function include_widgets() {
				include_once( 'classes/widget.php' );
				
			}	
			function add_to_footer()
			{
				if(get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use')=='on')
				{
					require_once(__PW_ROOT_WOO_AD_SEARCH__.'/includes/favorite.php');
				}
			}
			function frontend_init()
			{
				//require_once('includes/frontend-embed.php');
			}// end aio_init		
			
			
			function alert($type,$message)
			{
				switch($type)
				{
					case "error":
						return '<div class="message-cnt woo-err-msg"><i class="fa fa-times "></i><span>'.$message.'</span></div>';
					break;
					
					case "success":
						return '<div class="message-cnt woo-succ-msg"><i class="fa fa-check"></i><span>'.$message.'</span></div>';
					break;
				}
			}
			
			function check_isset($parameter,$type,$alternative_value)
			{
				switch($type)
				{
					case "theme_option":
						return ((isset($this->theme_option[$parameter]) ? $this->theme_option[$parameter]:$alternative_value));
					break;
					
					case "custom_field":
						return ((isset($this->custom_field[$parameter]) ? $this->custom_field[$parameter]:$alternative_value));
					break;
					
					case "taxonomy":
						return ((isset($this->custom_taxonomy[$parameter]) ? $this->custom_taxonomy[$parameter]:$alternative_value));
					break;
				}
				
			}
			
			function check_empty($parameter,$type,$alternative_value)
			{
				switch($type)
				{
					case "theme_option":
						return ((isset($this->theme_option[$parameter]) ? $alternative_value:$this->theme_option[$parameter]));
					break;
					
					case "custom_field":
						return ((isset($this->custom_field[$parameter]) ? $alternative_value:$this->custom_field[$parameter]));
					break;
					
					case "taxonomy":
						return ((isset($this->custom_taxonomy[$parameter]) ? $alternative_value:$this->custom_taxonomy[$parameter]));
					break;
				}
				
			}
			
			
			function isSerialized($str) {
				return ($str == serialize(false) || @unserialize($str) !== false);
			}
			
			function fetch_custom_fields($post_id)
			{
				$this->custom_field=array();
				$custom_fields = get_post_custom($post_id,true);
				if(is_array($custom_fields))
				{
					foreach ( $custom_fields as $key => $value ) {
						$this->custom_field[$key]=($this->isSerialized($value[0]) ? unserialize($value[0]):$value[0]);
					}
				}
				
			}
			
			function pw_woo_ad_search_grid( $atts, $content = null ){
				
				
				//////////MAIN CSS//////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'front-end-css');
				
				//////////LAYOUT//////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'layout');
				
				//////////BOOTSTRAP//////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'framework');
				
				//FONTAWESOME STYLE //font-awesome-css
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'font-awesome-ccc');
				
				//////////////TOOLTIP//////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tooltip-style');
				
				////////////////////////SEARCH FRAMEWORK///////////////////////
				wp_enqueue_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'search-framework');
				
				//////////PRETTY MULTI SELECT/////////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'multiselect');
				//wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'multiselect-pretify',      __PW_WOO_AD_SEARCH_CSS__ . 'front-end/multiselect/prettify.css', array() , null);
				
				
				///////////////////////////////STICKY///////////////////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'extra-button-style');
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'scroller-style');
				
				
				/////////////////////////CSS CHOSEN///////////////////////
				wp_enqueue_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_css_1' );
				
				////////////////////BX- SLider//////////////////////////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'bx-slider');
				
				////////////////////OWL- SLider//////////////////////////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'owl-slider');
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'owl-slider-theme');
				
				/////////////////////////PRICE SLIDER///////////////////////
				wp_enqueue_style( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'jquery-ui-style-slider');
				
				///////////////////POPUP STYLE//////////////////////////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup-style');
				
				///////////////////LIGHTBOX//////////////////////////////
				wp_enqueue_style(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'lightbox-style');
				
				///////////////////EQUAL HEIGHT//////////////////////////////
				
				
				
				/////COLOR PICKKER//////
				//wp_enqueue_style( 'wp-color-picker' );
				
				/////JS ENQUEUE////////////
				wp_enqueue_script('jquery');
				
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-slider');
				
				//wp_enqueue_script('wp-color-picker');
				
				//FOR UPLOAD FILE IN TAXONOMY
				//wp_enqueue_media();
				
				//////////////////CHOSEN//////////////////////////
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'chosen_js1' );
				
				//////////////////TOOLTIP//////////////////////////
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'tooltip-jquery' );
				
				//////////////////DEPENDENCY//////////////////////////
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'dependency' );
				
				//////////////////////////STICKY/////////////////////////
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'extra-button-script');
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'scroller-script');		
				
				//////////////////BOOTSTRAP - MULTI SELECT///////////////////
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'boostrap');
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'multiselect');
				//wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'prettify', __PW_WOO_AD_SEARCH_JS__.'front-end/multiselect/prettify.js', array( 'jquery' ),true );
				
				//////////////////SVG////////////////////
				wp_enqueue_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'svg');
				
				
				//////////////////////BX- SLider////////////////////////
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'bx-slider');
				
				//////////////////////OWL - SLider////////////////////////
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'owl-slider');
				
				////////////////////////COOKIE//////////////////
				wp_enqueue_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'jquery-cookie');
				
				//////////////////Masonry////////////////////
				wp_enqueue_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'masonry');
				
				//////////////////POPUP SCRIPT////////////////////
				wp_enqueue_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup-script');
				wp_enqueue_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'easing');
				
				//////////////////LIGHTBOX////////////////////
				wp_enqueue_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'lightbox-script');
		
				//////////////////Masonry////////////////////
				wp_enqueue_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'wait-image-load');
				
				//////////////////EQUAL HEIGHT////////////////////
				wp_enqueue_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'js-equalheight');
		
		
				//////////////////CUSTOM JS////////////////////
				wp_enqueue_script(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'front-custom-js');
				wp_localize_script( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'front-custom-js', 'parameters', array(
					'ajaxurl' => admin_url( 'admin-ajax.php'),
					'template_url' => __PW_WOO_AD_SEARCH_URL__,
					'popup_overlay_color' => (get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup_overlay_color')!='' ? get_option(__PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup_overlay_color'):"#333"),
					'woo_currency_symbol' 	=> get_woocommerce_currency_symbol(),
					'woo_currency_pos'      => get_option( 'woocommerce_currency_pos' ),
					
				) );
				
				
				
				extract( shortcode_atts( array(
					'id'   => '',
				), $atts ) );
				$this->fetch_custom_fields($id);
				
				$shortcode_id=$id;
				
				require __PW_ROOT_WOO_AD_SEARCH__.'/frontend/search-form.php';
				return $final_output;
			}
			
			public function on_activation() {
				
				if(get_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_icon_type')=='')
				{
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'price_step', '1' );
					
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_type', 'loading_pack' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_pack', 'fa-loading-1' );
					
					// -=> set loading image
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_pack_font_icon', '#f7f7f7' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'loading_color', '#ffffff' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup_bg_color', '#ffffff' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'popup_overlay_color', '#ffffff' );
					
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_enable_favorite_use', 'on' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_margin', '100' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_position', 'right' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_icon_type', 'fontawesome' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_favorite_font_icon', 'fa-heart' );
					
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_margin', '100' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_position', 'left' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_icon_type', 'fontawesome' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_font_icon', 'fa-search' );
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'option_search_height', '500' );
					
					update_option( __PW_WOO_AD_SEARCH_FIELDS_PERFIX__.'sendto_form_fields', array('name_from','name_to','email','description'));
				}
			}
			
			/*public function excerpt($excerpt,$limit) {
				$excerpt = explode(' ', $excerpt, $limit);
				if (count($excerpt)>=$limit) {
					array_pop($excerpt);
					$excerpt = implode(" ",$excerpt).'...';
				} else {
					$excerpt = implode(" ",$excerpt);
				} 
				$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
				return $excerpt;
			}*/
			
			public function excerpt($text,$excerpt_length) {
				global $post;
				
				if ( '' == $text ) {
					$text = get_the_content('');
					$text = apply_filters('the_content', $text);
					$text = str_replace('\]\]\>', ']]&gt;', $text);
					$text = strip_tags($text);
					
					$words = explode(' ', $text, $excerpt_length + 1);
					
					if (count($words)> $excerpt_length) {
					  array_pop($words);
					  array_push($words, '[...]');
					  $text = implode(' ', $words);
					}
				}else
				{
					$text = str_replace('\]\]\>', ']]&gt;', $text);
					$text = strip_tags($text);
					
					$words = explode(' ', $text, $excerpt_length + 1);
					
					if (count($words)> $excerpt_length) {
					  array_pop($words);
					  array_push($words, '[...]');
					  $text = implode(' ', $words);
					}
				}
				return $text;
			}
		}
		
		$GLOBALS['pw_woo_ad_main_class'] = new PW_WOO_AD_SEARCH;
	}
}else
{
	add_action( 'admin_notices', 'pw_woo_ad_search_admin_notice_for_version');
	function pw_woo_ad_search_admin_notice_for_version()
	{
		echo '<div class="updated"><p>'.__("The", __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ).' <strong>'.__("WooCommerce Magic Grid", __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ).'</strong> '.__("plugin requires", __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ).' <strong>'.__("WooCommerce Plugin", __PW_WOO_AD_SEARCH_TEXTDOMAIN__ ).'</strong>.</p></div>';	
	}
}
?>