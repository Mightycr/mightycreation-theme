<?php

//add styles and scripts
function journe_scripts_styles()
{
    $ver = time();
    wp_dequeue_style('wp-block-library');

    //OWL Carousel
    wp_enqueue_style('owl', get_template_directory_uri() . '/owl/css/owl.carousel.min.css', array(), '2.2.1');
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/owl/js/owl.carousel.min.js', array('jquery'), '2.2.1', true);
    wp_enqueue_script('owl-carousel-init', get_template_directory_uri() . '/owl/js/owl.carousel-init.js', array('jquery'), $ver, true);

    //Main Style
    wp_enqueue_style('style-reset', get_template_directory_uri() . '/css/reset.css', array(), $ver);
    wp_enqueue_style('style-fonts', get_template_directory_uri() . '/fonts/sofia-pro-light/style.css', array(), $ver);
    wp_enqueue_style('style-grid', get_template_directory_uri() . '/css/grid.css', array(), $ver);
    wp_enqueue_style('style-block-grid', get_template_directory_uri() . '/css/block-grid.css', array(), $ver);
    wp_enqueue_style('style-custom', get_template_directory_uri() . '/css/custom.css', array(), $ver);
    wp_enqueue_style('style', get_stylesheet_uri(), false, $ver);

    //Main Script
    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array('jquery'), $ver, true);
    wp_localize_script('main', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'journe_scripts_styles');


//register_custom_menu
function register_custom_menu()
{
    register_nav_menus(
        array(
            'main_menu' => __('Main Menu'),
            'secondary_menu' => __('Secondary Menu'),
            'social_networks_menu' => __('Social Networks Menu')
        )
    );
}
add_action('init', 'register_custom_menu');


//Enable post featured images
function mytheme_post_thumbnails()
{
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'mytheme_post_thumbnails');

//Enable post formats
function wpsites_child_theme_posts_formats()
{
    add_theme_support('post-formats', array(
        'video',
    ));
}
add_action('after_setup_theme', 'wpsites_child_theme_posts_formats', 11);

//Section widgets
function section_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Right menu', 'section'),
        'id'            => 'section-widget-1',
        'description'   => __('Appears in the right site.', 'section'),
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title' => '',
        'after_title' => ''
    ));
    register_sidebar(array(
        'name'          => __('Social networks', 'section'),
        'id'            => 'section-widget-2',
        'description'   => __('Appears in the left bottom site.', 'section'),
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title' => '',
        'after_title' => ''
    ));
}
add_action('widgets_init', 'section_widgets_init');


//Remove margin top from HTML
function remove_admin_login_header()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');


//Declaring WooCommerce support
function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

//Remove woocommerce style
//add_filter('woocommerce_enqueue_styles', '__return_empty_array');

//Change of the logo in Login page
function my_login_logo_one()
{
?>
    <style type="text/css">
        body.login {
            background: #fff;
        }

        body.login div#login h1 a {
            background-image: url(https://mightycreation.com/wp-content/themes/mighty-creation/images/logo-black.png);
            display: block;
            background-size: 130px 46px;
            width: 130px;
            height: 46px;
            outline: 0;
        }
    </style>
<?php
}
add_action('login_enqueue_scripts', 'my_login_logo_one');


//Redirect Add to cart to Checkout page
add_filter('add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout()
{
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}

//Checkout placeholder
add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
function override_billing_checkout_fields( $fields ) {
    $fields['billing']['billing_phone']['placeholder'] = 'Phone *';
    $fields['billing']['billing_email']['placeholder'] = 'E-mail address *';
    return $fields;
}
add_filter('woocommerce_default_address_fields', 'override_default_address_checkout_fields', 20, 1);
function override_default_address_checkout_fields( $address_fields ) {
    $address_fields['first_name']['placeholder'] = 'First name *';
    $address_fields['last_name']['placeholder'] = 'Last name *';
    $address_fields['address_1']['placeholder'] = 'Street address *';
    $address_fields['state']['placeholder'] = 'State *';
    $address_fields['postcode']['placeholder'] = 'Zip code *';
    $address_fields['city']['placeholder'] = 'City/Town *';
    $address_fields['company']['placeholder'] = 'Company name';
    return $address_fields;
}


//Remove Checkout Additional information
add_filter('woocommerce_enable_order_notes_field', '__return_false');




 add_filter( 'woocommerce_cart_item_name', 'ts_product_image_on_checkout', 10, 3 );
 
 function ts_product_image_on_checkout( $name, $cart_item, $cart_item_key ) {
      
     /* Return if not checkout page */
     if ( ! is_checkout() ) {
         return $name;
     }
      
     /* Get product object */
     $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
  
     /* Get product thumbnail */
     $thumbnail = $_product->get_image();
  
     /* Add wrapper to image and add some css */
     $image = '<div class="product-image">'
                 . $thumbnail .
             '</div>'; 
  
     /* Prepend image to name and return it */
     return $image . $name;
 }



//Add custom text in checkout order view
 function filter_woocommerce_cart_item_subtotal( $subtotal, $cart_item, $cart_item_key ) {
    if ( is_checkout() ) {  
        $price_title = 'Product';
        $line_subtotal = $cart_item['line_subtotal'];
        $subtotal = '<span>' . $price_title . '</span>';
        $subtotal .= wc_price( $line_subtotal );
    }
    return $subtotal;
}
add_filter( 'woocommerce_cart_item_subtotal', 'filter_woocommerce_cart_item_subtotal', 10, 3 );


function custom_remove_all_quantity_fields( $return, $product ) {return true;}
add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );


// Main menu: remove "All Logos", append secondary menu items, reorder
add_filter('wp_nav_menu_objects', function($items, $args) {
    if (!isset($args->theme_location) || $args->theme_location !== 'main_menu') return $items;

    // Remove "All Logos"
    $items = array_filter($items, function($item) {
        return strtolower(trim($item->title)) !== 'all logos';
    });

    // Append About me, Testimonials etc. from secondary_menu
    $locations = get_nav_menu_locations();
    if (!empty($locations['secondary_menu'])) {
        $secondary_items = wp_get_nav_menu_items($locations['secondary_menu']);
        if ($secondary_items && !is_wp_error($secondary_items)) {
            foreach ($secondary_items as $sec_item) {
                $items[] = $sec_item;
            }
        }
    }

    // Order: Logos for sale first, Sold logos second, rest after
    $order = ['logos for sale' => 0, 'sold logos' => 1];
    usort($items, function($a, $b) use ($order) {
        $a_pos = $order[strtolower(trim($a->title))] ?? 99;
        $b_pos = $order[strtolower(trim($b->title))] ?? 99;
        return $a_pos - $b_pos;
    });

    return $items;
}, 10, 2);

// Mark "Logos for sale" as active when on the home page
add_filter('nav_menu_css_class', function($classes, $item, $args) {
    if (!isset($args->theme_location) || $args->theme_location !== 'main_menu') return $classes;
    if (is_front_page() && strtolower(trim($item->title)) === 'logos for sale') {
        $classes[] = 'current-menu-item';
    }
    return $classes;
}, 10, 3);


// Testimonial meta box on product edit screen
function mc_testimonial_meta_box() {
    add_meta_box('mc_testimonial', 'Client Testimonial', 'mc_testimonial_meta_box_cb', 'product', 'normal', 'default');
}
add_action('add_meta_boxes', 'mc_testimonial_meta_box');

function mc_testimonial_meta_box_cb($post) {
    wp_nonce_field('mc_testimonial_nonce', 'mc_testimonial_nonce_field');
    $quote       = get_post_meta($post->ID, '_testimonial_quote', true);
    $author_name = get_post_meta($post->ID, '_testimonial_author_name', true);
    $author_role = get_post_meta($post->ID, '_testimonial_author_role', true);
    ?>
    <p><label>Testimonial</label><br>
    <textarea name="testimonial_quote" rows="4" style="width:100%"><?php echo esc_textarea($quote); ?></textarea></p>
    <p><label>Client Name</label><br>
    <input type="text" name="testimonial_author_name" value="<?php echo esc_attr($author_name); ?>" style="width:100%"></p>
    <p><label>Client Role / Company</label><br>
    <input type="text" name="testimonial_author_role" value="<?php echo esc_attr($author_role); ?>" style="width:100%"></p>
    <?php
}

function mc_save_testimonial_meta($post_id) {
    if (!isset($_POST['mc_testimonial_nonce_field']) || !wp_verify_nonce($_POST['mc_testimonial_nonce_field'], 'mc_testimonial_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    update_post_meta($post_id, '_testimonial_quote',       sanitize_textarea_field($_POST['testimonial_quote'] ?? ''));
    update_post_meta($post_id, '_testimonial_author_name', sanitize_text_field($_POST['testimonial_author_name'] ?? ''));
    update_post_meta($post_id, '_testimonial_author_role', sanitize_text_field($_POST['testimonial_author_role'] ?? ''));
}
add_action('save_post', 'mc_save_testimonial_meta');

?>