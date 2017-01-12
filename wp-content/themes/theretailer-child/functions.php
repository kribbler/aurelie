<?php
add_image_size('home_thumbs', 500, 500, true);

add_filter('woocommerce_add_cart_item', 'my_add_cart_item', 10, 2);
function my_add_cart_item($cart_item){
    if ($_POST['engraving_text'] != 'ANGI GRAVERINGSTEKST')
        $cart_item['engraving_text'] = $_POST['engraving_text'];
    return $cart_item;
}

add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_custom_data_vase', 10, 2 );
function add_cart_item_custom_data_vase( $cart_item_meta, $product_id ) {
  global $woocommerce; 
  if ($_POST['engraving_text'] != 'ANGI GRAVERINGSTEKST')
    $cart_item_meta['engraving_text'] = $_POST['engraving_text'];
  //var_dump($cart_item_meta);die();
  return $cart_item_meta; 
}

//Get it from the session and add it to the cart variable
function get_cart_items_from_session( $item, $values, $key ) {
    //echo 'www.xxs';die();

    //echo "<pre>"; var_dump($values);var_dump($item); echo "</pre>";
    if ( array_key_exists( 'engraving_text', $values ) )
        $item[ 'engraving_text' ] = $values['engraving_text'];

    //echo '<pre>'; var_dump($item); echo "</pre>";
    return $item;
}
add_filter( 'woocommerce_get_cart_item_from_session', 'get_cart_items_from_session', 1, 3 );

add_action('woocommerce_add_order_item_meta',   'order_item_meta_2', 10, 2);
function order_item_meta_2($item_id, $values) {
    if (function_exists('woocommerce_add_order_item_meta')) {
        if ($values['engraving_text'])
            woocommerce_add_order_item_meta($item_id, 'GRAVERING: ', $values['engraving_text']);
    }
    wp_mail("daniel.oraca@gmail.com", "Aurelie Google Analytics", $engraving_text, $headers);
} 

add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');
function my_custom_checkout_field_update_order_meta( $order_id, $values ) {
    global $woocommerce;
    $engraving_text = "";

    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) :
        $_product = $values;
        $engraving_text .= '';
        $engraving_text .= (isset($values['engraving_text'])) ? 'GRAVERING: ' . $values['engraving_text'] . ' | ' : "";
        $engraving_text .= get_permalink($values['product_id']);
        $engraving_text .= ' ||| ';
        //$x = woocommerce_add_order_item_meta( $_product['product_id'], 'engraving_text', $values['engraving_text'], true );
        //echo "<pre>"; var_dump($_product['product_id']);var_dump($values['engraving_text']);var_dump($x);die();  

    endforeach;
    if ($engraving_text){
        $x = update_post_meta( $order_id, 'engraving_text', $engraving_text);
        //var_dump($x);
        //var_dump($order_id);
        //var_dump($engraving_text);
    }

    $headers = 'From: no-reply <no-reply@aurelie.no>' . "\r\n";
    wp_mail("daniel.oraca@gmail.com", "Aurelie Google Analytics", $engraving_text, $headers);
    //die();
} 

if ( is_admin() && isset( $_GET['taxonomy'] ) && ($_GET['taxonomy'] == 'product_cat') &&
    ( !isset( $options['tax-hideeditbox-' . $_GET['taxonomy']] ) || !$options['tax-hideeditbox-' . $_GET['taxonomy']] )
) {
    //echo 'super! Im here now on functions.php'; var_dump ($_GET['taxonomy']);
    add_action( $_GET['taxonomy'] . '_edit_form', 'my_term_seo_form' , 10, 1 );
    
}
add_action( 'edit_term', 'update_category_term' , 99, 3 );

function my_term_seo_form( $term ) {
    
    $tax_meta = get_option( 'my_wpseo_taxonomy_meta' );
    $options  = get_wpseo_options();

    if ( isset( $tax_meta[$term->taxonomy][$term->term_id] ) )
        $tax_meta = $tax_meta[$term->taxonomy][$term->term_id];

    echo '<h2>' . __( 'Special Category Settings', 'wordpress-seo' ) . '</h2>';
    echo '<table class="form-table">';

    form_row( 'wpcategory_extra_text', __( 'Category Extra Text', 'wordpress-seo' ), NULL, $tax_meta );
    form_row( 'wpcategory_extra_text_bold', __( 'Is Bold?', 'wordpress-seo' ), NULL, $tax_meta, 'checkbox');

    echo '</table>';
}

function form_row( $var, $label, $desc, $tax_meta, $type = 'text', $options = array() ) {
    $val = '';
    if ( isset( $tax_meta[$var] ) && !empty( $tax_meta[$var] ) )
        $val = stripslashes( $tax_meta[$var] );

    echo '<tr class="form-field">' . "\n";
    echo "\t" . '<th scope="row" valign="top"><label for="' . $var . '">' . $label . ':</label></th>' . "\n";
    echo "\t" . '<td>' . "\n";
    if ( $type == 'text' ) {
        ?>
    <input name="<?php echo $var; ?>" id="<?php echo $var; ?>" type="text" value="<?php echo $val; ?>" size="40"/>
    <p class="description"><?php echo $desc; ?></p>
    <?php
    } else if ( $type == 'checkbox' ) {
        ?>
    <input name="<?php echo $var; ?>" id="<?php echo $var; ?>" type="checkbox" <?php show_checked( $val ); ?>/>
    <?php
    } else if ( $type == 'select' ) {
        ?>
    <select name="<?php echo $var; ?>" id="<?php echo $var; ?>">
        <?php foreach ( $options as $option => $label ) {
        $sel = '';
        if ( $option == $val )
            $sel = " selected='selected'";
        echo "<option" . $sel . " value='" . $option . "'>" . $label . "</option>";
    }?>
    </select>
    <?php
    }
    echo "\t" . '</td>' . "\n";
    echo '</tr>' . "\n";

}

function show_checked($val){
    if ($val == 'on'){
        echo  "checked";
    }
}

function update_category_term( $term_id, $tt_id, $taxonomy ) {
    //echo '<pre>';var_dump($_POST); die();
    $tax_meta = get_option( 'my_wpseo_taxonomy_meta' );

    if ( !isset($tax_meta[$taxonomy]) || !isset($tax_meta[$taxonomy][$term_id]) || !is_array( $tax_meta[$taxonomy][$term_id] ) )
        $tax_meta[$taxonomy][$term_id] = array();

    foreach ( array( 'extra_text', 'extra_text_bold' ) as $key ) {
        if ( isset( $_POST['wpcategory_' . $key] ) && !empty( $_POST['wpcategory_' . $key] ) ) {
            $val = trim( $_POST['wpcategory_' . $key] );

            if ( $key == 'canonical' )
                $val = esc_url( $val );
            else
                $val = esc_html( $val );

            $tax_meta[$taxonomy][$term_id]['wpcategory_' . $key] = $val;
        } else {
            if ( isset( $tax_meta[$taxonomy][$term_id]['wpcategory_' . $key] ) )
                unset( $tax_meta[$taxonomy][$term_id]['wpcategory_' . $key] );
        }
    }

    update_option( 'my_wpseo_taxonomy_meta', $tax_meta, 99 );

    if ( defined( 'W3TC_DIR' ) && class_exists( 'W3_ObjectCache' ) ) {
        require_once( W3TC_DIR . '/lib/W3/ObjectCache.php' );
        $w3_objectcache = & W3_ObjectCache::instance();

        $w3_objectcache->flush();
    }
}

function se_customize_product_shortcode( $args, $atts ) {
    //if ( is_page( 'products' ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array( 'perlearmband', 'perle-orepynt' ),
                'operator' => 'NOT IN'
            )
       );
    //}

    if ($_SERVER['REMOTE_ADDR'] == '151.230.240.5') {
        echo "<pre>"; var_dump($args); echo "</pre>";
    }
    return $args;
}
add_filter( 'woocommerce_shortcode_products_query', 'se_customize_product_shortcode', 10, 2 );

add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

function custom_pre_get_posts_query( $q ) {

    if ( ! $q->is_main_query() ) return;
    if ( ! $q->is_post_type_archive() ) return;
    
    //if ( ! is_admin() && is_shop() ) {

        $q->set( 'tax_query', array(array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array( 'perle-orepynt' ), // Don't display products in the knives category on the shop page
            'operator' => 'NOT IN'
        )));
    
    //}

    remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

}

add_filter( 'woocommerce_product_categories_widget_dropdown_args', 'rv_exclude_wc_widget_categories' );
//* Used when the widget is displayed as a list
add_filter( 'woocommerce_product_categories_widget_args', 'rv_exclude_wc_widget_categories' );
function rv_exclude_wc_widget_categories( $cat_args ) {
    //echo "<pre>"; var_dump($cat_args);
    $cat_args['exclude'] = array('937','123--'); // Insert the product category IDs you wish to exclude

    $cat_args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array( 'perlearmband', 'perle-orepynt' ),
                'operator' => 'NOT IN'
            )
       );

    return $cat_args;
}