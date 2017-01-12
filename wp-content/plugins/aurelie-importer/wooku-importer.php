<?php /*
    Plugin Name: Aurelie Importer
    Plugin URI: http://oku.no
    Description: Free CSV import utility for WooCommerce
    Version: 1
    Author: Daniel Oraca
    Author URI: 
    Text Domain: wooku-importer
    Domain Path: /languages/
*/

    class Aurelie_Importer {
        
        public function __construct() {
            add_action( 'init', array( 'Aurelie_Importer', 'translations' ), 1 );
            add_action('admin_menu', array('Aurelie_Importer', 'admin_menu'));
            add_action('wp_ajax_wooku-importer-ajax', array('Aurelie_Importer', 'render_ajax_action'));
			add_action('wp_ajax_wooku-importer-check-duplicate', array('Aurelie_Importer', 'render_ajax_action_check_duplicate'));
        }

        public function translations() {
            load_plugin_textdomain( 'wooku-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }

        public function admin_menu() {
            add_management_page( __( 'Aurelie Product Importer', 'wooku-importer' ), __( 'Aurelie Importer', 'wooku-importer' ), 'manage_options', 'wooku-importer', array('Aurelie_Importer', 'render_admin_action'));
        }
        
        public function render_admin_action() {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'upload';
            require_once(plugin_dir_path(__FILE__).'wooku-importer-common.php');
            require_once(plugin_dir_path(__FILE__)."wooku-importer-{$action}.php");
        }
        
        public function render_ajax_action() {
            require_once(plugin_dir_path(__FILE__)."wooku-importer-ajax.php");
            die(); // this is required to return a proper result
        }

		public function render_ajax_action_check_duplicate(){
			require_once(plugin_dir_path(__FILE__)."check_duplicate.php");
			die();
		}
    }
    
    $Aurelie_importer = new Aurelie_Importer();