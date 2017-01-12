<?php /*
    Plugin Name: Woo OKU Monitoring
    Plugin URI: http://oku.no
    Description: Woo Oku Monitoring
    Version: 1
    Author: Daniel Oraca
    Author URI: 
    Text Domain: wooku-monitoring
    
*/

	class Wooku_Monitoring {
        
        public function __construct() {
            add_action( 'init', array( 'Wooku_Monitoring', 'translations' ), 1 );
            add_action('admin_menu', array('Wooku_Monitoring', 'admin_menu'));
            add_action('wp_ajax_wooku-monitoring-ajax', array('Wooku_Monitoring', 'render_ajax_monitoring_action'));
            add_action('wp_ajax_wooku-load-products-ajax', array('Wooku_Monitoring', 'render_ajax_load_products_action'));
            add_action('wp_ajax_wooku-save-paused-process-ajax', array('Wooku_Monitoring', 'render_ajax_save_paused_process_action'));
            add_action('wp_ajax_wooku-delete-product-ajax', array('Wooku_Monitoring', 'render_ajax_delete_product_action'));
            add_action('wp_ajax_wooku-trash-product-ajax', array('Wooku_Monitoring', 'render_ajax_trash_product_action'));
            add_action('wp_ajax_wooku-pending-product-ajax', array('Wooku_Monitoring', 'render_ajax_pending_product_action'));
            add_action('wp_ajax_wooku-load-products-to-delete-ajax', array('Wooku_Monitoring', 'render_ajax_delete_all_products_action'));
        }

		public function translations() {
            load_plugin_textdomain( 'wooku-monitoring', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }
        
        public function admin_menu() {
            add_management_page( __( 'WoOKU Product Monitoring', 'wooku-monitoring' ), __( 'WoOKU Monitoring', 'wooku-monitoring' ), 'manage_options', 'wooku-monitoring', array('Wooku_Monitoring', 'render_admin_action'));
        }
        
        public function render_admin_action() {
			$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'init';
			require_once(plugin_dir_path(__FILE__).'wooku-monitoring-common.php');
			require_once(plugin_dir_path(__FILE__)."wooku-monitoring-{$action}.php");
        }
        
		public function render_ajax_monitoring_action() {
        	require_once(plugin_dir_path(__FILE__).'wooku-monitoring-common.php');
            require_once(plugin_dir_path(__FILE__).'wooku-monitoring-ajax.php');
            die(); // this is required to return a proper result
        }
        
		public function render_ajax_load_products_action() {
        	require_once(plugin_dir_path(__FILE__).'wooku-monitoring-common.php');
            require_once(plugin_dir_path(__FILE__).'wooku-load-products-ajax.php');
            die(); // this is required to return a proper result
        }
        
		public function render_ajax_save_paused_process_action() {
        	require_once(plugin_dir_path(__FILE__).'wooku-monitoring-common.php');
            require_once(plugin_dir_path(__FILE__).'wooku-save-paused-process-ajax.php');
            die(); // this is required to return a proper result
        }
        
		public function render_ajax_delete_product_action() {
        	require_once(plugin_dir_path(__FILE__).'wooku-monitoring-common.php');
            require_once(plugin_dir_path(__FILE__).'wooku-delete-product-ajax.php');
            die(); // this is required to return a proper result
        }
        
		public function render_ajax_trash_product_action() {
        	require_once(plugin_dir_path(__FILE__).'wooku-monitoring-common.php');
            require_once(plugin_dir_path(__FILE__).'wooku-trash-product-ajax.php');
            die(); // this is required to return a proper result
        }
        
		public function render_ajax_pending_product_action() {
        	require_once(plugin_dir_path(__FILE__).'wooku-monitoring-common.php');
            require_once(plugin_dir_path(__FILE__).'wooku-pending-product-ajax.php');
            die(); // this is required to return a proper result
        }
        
		public function render_ajax_delete_all_products_action() {
        	require_once(plugin_dir_path(__FILE__).'wooku-monitoring-common.php');
            require_once(plugin_dir_path(__FILE__).'wooku-load-products-to-delete-ajax.php');
            die(); // this is required to return a proper result
        }
        
    }
    
    $Wooku_monitoring = new Wooku_Monitoring();