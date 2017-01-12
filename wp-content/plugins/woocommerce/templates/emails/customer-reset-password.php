<?php
/**
 * Customer Reset Password email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action('woocommerce_email_header', $email_heading); ?>

<p><?php _e( 'Noen ønsker å nullstille passordet for følgende konto:', 'woocommerce' ); ?></p>
<p><?php printf( __( 'Brukernavn: %s', 'woocommerce' ), $user_login ); ?></p>
<p><?php _e( 'Hvis du mener dette er feil kan du bare overse denne e-posten. Da vil ingen endringer skje.', 'woocommerce' ); ?></p>
<p><?php _e( 'For å nullstille passordet ditt besøker du denne adressen:', 'woocommerce' ); ?></p>
<p>
    <a href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'login' => rawurlencode( $user_login ) ), get_permalink( woocommerce_get_page_id( 'lost_password' ) ) ) ); ?>">
			<?php _e( 'Klikk her for å nullstille passordet ditt', 'woocommerce' ); ?></a>
</p>
<p></p>

<?php do_action('woocommerce_email_footer'); ?>