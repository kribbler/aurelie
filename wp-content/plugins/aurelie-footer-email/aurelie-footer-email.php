<?php /*
    Plugin Name: Aurelie Footer Email
    Plugin URI: http://aurelie.no
    Description: Aurelie Footer Email
    Version: 1
    Author: Daniel Oraca
    Author URI: 
    
    
*/

	class Aurelie_Footer_Email {
        
        public function __construct() {
            add_action( 'init', array( 'Aurelie_Footer_Email', 'init' ), 1 );
        }

        
		function init(){
			add_filter('woocommerce_email_settings', 'aurelie_woocommerce_email_settings', 10, 2);
			
			function aurelie_woocommerce_email_settings(){
				$x = array(
					array( 'type' => 'sectionend', 'id' => 'email_recipient_options' ),

					array(	'title' => __( 'Email Sender Options', 'woocommerce' ), 'type' => 'title', 'desc' => __( 'The following options affect the sender (email address and name) used in WooCommerce emails.', 'woocommerce' ), 'id' => 'email_options' ),
				
					array(
						'title' => __( '"From" Name', 'woocommerce' ),
						'desc' 		=> '',
						'id' 		=> 'woocommerce_email_from_name',
						'type' 		=> 'text',
						'css' 		=> 'min-width:300px;',
						'default'	=> esc_attr(get_bloginfo('title'))
					),
				
					array(
						'title' => __( '"From" Email Address', 'woocommerce' ),
						'desc' 		=> '',
						'id' 		=> 'woocommerce_email_from_address',
						'type' 		=> 'email',
						'custom_attributes' => array(
							'multiple' 	=> 'multiple'
						),
						'css' 		=> 'min-width:300px;',
						'default'	=> get_option('admin_email')
					),
				
					array( 'type' => 'sectionend', 'id' => 'email_options' ),
				
					array(	'title' => __( 'Email Template', 'woocommerce' ), 'type' => 'title', 'desc' => sprintf(__( 'This section lets you customise the WooCommerce emails. <a href="%s" target="_blank">Click here to preview your email template</a>. For more advanced control copy <code>woocommerce/templates/emails/</code> to <code>yourtheme/woocommerce/emails/</code>.', 'woocommerce' ), wp_nonce_url(admin_url('?preview_woocommerce_mail=true'), 'preview-mail')), 'id' => 'email_template_options' ),
				
					array(
						'title' => __( 'Header Image', 'woocommerce' ),
						'desc' 		=> sprintf(__( 'Enter a URL to an image you want to show in the email\'s header. Upload your image using the <a href="%s">media uploader</a>.', 'woocommerce' ), admin_url('media-new.php')),
						'id' 		=> 'woocommerce_email_header_image',
						'type' 		=> 'text',
						'css' 		=> 'min-width:300px;',
						'default'	=> ''
					),
				
					array(
						'title' => __( 'Email Footer Text', 'woocommerce' ),
						'desc' 		=> __( 'The text to appear in the footer of WooCommerce emails.', 'woocommerce' ),
						'id' 		=> 'woocommerce_email_footer_text',
						'css' 		=> 'width:100%; height: 75px;',
						'type' 		=> 'textarea',
						'default'	=> get_bloginfo('title') . ' - ' . __( 'Powered by WooCommerce', 'woocommerce' )
					),
				
					array(
						'title' => __( 'Base Colour', 'woocommerce' ),
						'desc' 		=> __( 'The base colour for WooCommerce email templates. Default <code>#557da1</code>.', 'woocommerce' ),
						'id' 		=> 'woocommerce_email_base_color',
						'type' 		=> 'color',
						'css' 		=> 'width:6em;',
						'default'	=> '#557da1'
					),
				
					array(
						'title' => __( 'Background Colour', 'woocommerce' ),
						'desc' 		=> __( 'The background colour for WooCommerce email templates. Default <code>#f5f5f5</code>.', 'woocommerce' ),
						'id' 		=> 'woocommerce_email_background_color',
						'type' 		=> 'color',
						'css' 		=> 'width:6em;',
						'default'	=> '#f5f5f5'
					),
				
					array(
						'title' => __( 'Email Body Background Colour', 'woocommerce' ),
						'desc' 		=> __( 'The main body background colour. Default <code>#fdfdfd</code>.', 'woocommerce' ),
						'id' 		=> 'woocommerce_email_body_background_color',
						'type' 		=> 'color',
						'css' 		=> 'width:6em;',
						'default'	=> '#fdfdfd'
					),
				
					array(
						'title' => __( 'Email Body Text Colour', 'woocommerce' ),
						'desc' 		=> __( 'The main body text colour. Default <code>#505050</code>.', 'woocommerce' ),
						'id' 		=> 'woocommerce_email_text_color',
						'type' 		=> 'color',
						'css' 		=> 'width:6em;',
						'default'	=> '#505050'
					),
				
					array(
						'title' => 'Footer Text on Emails',
						'desc'	=> '<br />another text field could be placed somewhere in the admin panel that will apply as footer text both for all the templates, both web and e-mail.',
						'id'	=> 'woocommerce_email_footer_text',
						'type' 		=> 'text',
						'css' 		=> 'min-width:300px;',
						'default'	=> ''
					),
					array( 'type' => 'sectionend', 'id' => 'email_template_options' ),
				
				);
	        	return $x;
	        }
			
			
		}        
    }
    
    $Aurelie_Footer_Email = new Aurelie_Footer_Email();