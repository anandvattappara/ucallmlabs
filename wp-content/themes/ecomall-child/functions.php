<?php 
add_post_type_support('page','excerpt');
function ecomall_child_register_scripts(){
    $parent_style = 'ecomall-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array('font-awesome-5', 'ecomall-reset'), ecomall_get_theme_version() );
    wp_enqueue_style( 'ecomall-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'ecomall_child_register_scripts', 99 );

add_filter( 'woocommerce_product_tabs', 'woo_custom_product_tabs' );
function woo_custom_product_tabs( $tabs ) {
	 unset( $tabs['reviews'] );
	 unset( $tabs['additional_information'] );
	 unset( $tabs['dimensions'] );
	 return $tabs;
}


// Callback to display cross sells
function woocommerce_cross_sell_display_in_tab() {
    global $product;
	 $limit = 3;
	 $columns = 3;
	 $orderby = 'rand';
	 $order = 'desc' ;
    $cross_sells = array_filter( array_map( 'wc_get_product', $product->get_cross_sell_ids() ), 'wc_products_array_filter_visible' );
	wc_get_template(
        'cart/accessories.php',
        array(
            'cross_sells'    => $cross_sells,

            // Not used now, but used in previous version of up-sells.php.
            'posts_per_page' => $limit,
            'orderby'        => $orderby,
            'columns'        => $columns,
        )
    );
	
}

add_filter( 'woocommerce_product_tabs', 'woo_accessories_product_tab' );
function woo_accessories_product_tab( $tabs ) {	
	// Adds the new tab
	$tabs['accessories_tab'] = array(
		'title' 	=> __( 'Product Accessories', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woocommerce_cross_sell_display_in_tab'
	);
	return $tabs;
}

function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );

add_action('woocommerce_after_add_to_cart_button','vwave_additional_button',50);
function vwave_additional_button() {
   	global $product;
	$productid = $product->get_id();
	$sku = $product->get_sku();
	$authorizeurl = esc_url(add_query_arg(array('productid' => $productid ,'sku' => $sku), site_url( '/authorize/' ) ) );
	$oemodmurl = esc_url(add_query_arg(array('productid' => $productid ,'sku' => $sku), site_url( '/oem-odm-form/' ) ) );
    echo '<a class="single_add_to_cart_button button oembtn" href="'.$authorizeurl.'">Authorize</a> <a class="single_add_to_cart_button button oembtn" href="'.$oemodmurl.'" >OEM & ODM</a>';    
}
add_action( 'woocommerce_before_add_to_cart_button', 'vwave_qunatity_slider' );
function vwave_qunatity_slider(){
	global $product;
	$productid = $product->get_id();
	echo '<div class="slidedesc">Enter the quantity you would like, or drag the panel to find the quantity and price that best for you</div>
	<div class="slidecontainer">
  <input type="range" min="0" max="0" value="0" class="slider-color" id="quantityRange">
</div>
<div id="savebadge"></div>';

echo '<script language="javascript">';
echo 'var slider = document.getElementById("quantityRange");
	slider.oninput = function() {
  	jQuery(".qty").val(this.value);
	var product_id = jQuery("input[name=product_id]").val();
	var variation_id = jQuery("input[name=variation_id]").val();
	var quantity = jQuery("input[name=quantity]").val();
	getsavedprice(product_id,variation_id,quantity);
};';

echo 'jQuery( document ).ready(function() {
   	jQuery(".qty").change(function(){
		var product_id = jQuery("input[name=product_id]").val();
		var variation_id = jQuery("input[name=variation_id]").val();
		var quantity = jQuery("input[name=quantity]").val();
		getsavedprice(product_id,variation_id,quantity);
	});
});';


echo '</script>';

}


/**
* Add billing fields 
*
*/
function vwave_register_function(){
		global $woocommerce;
		$checkout = $woocommerce->checkout();
		//print_r($checkout);
		$checkout_fields = $checkout->checkout_fields['billing'];
		unset( $checkout_fields['billing_email']);

		foreach ( $checkout_fields as $key => $field) :
			if($key=='billing_first_name' || $key=='billing_last_name'){
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
		endforeach;
		echo '<div class="clear"></div>';	
}
add_action('woocommerce_register_form_start','vwave_register_function');

/**
* Field Validation
*/
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
       if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {

              $validation_errors->add( 'billing_first_name_error', __( 'First name is required.', 'woocommerce' ) );

       } 

       if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {

              $validation_errors->add( 'billing_last_name_error', __( 'Last name is required.', 'woocommerce' ) );

       } 

       /*if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {

              $validation_errors->add( 'billing_phone_error', __( 'Phone is required.', 'woocommerce' ) );

       }
       if ( isset( $_POST['billing_company'] ) && empty( $_POST['billing_company'] ) ) {

              $validation_errors->add( 'billing_billing_company', __( 'Company Name is required.', 'woocommerce' ) );

       }     
       if ( isset( $_POST['billing_postcode'] ) && empty( $_POST['billing_postcode'] ) ) {

              $validation_errors->add( 'billing_billing_postcode', __( 'Postcode is required.', 'woocommerce' ) );

       }
        if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {

              $validation_errors->add( 'billing_billing_city', __( 'City/Subub is required.', 'woocommerce' ) );

       }
       if ( isset( $_POST['billing_address_1'] ) && empty( $_POST['billing_address_1'] ) ) {

              $validation_errors->add( 'billing_billing_address_1', __( 'Street Address is required.', 'woocommerce' ) );

       }
       if ( isset( $_POST['billing_country'] ) && empty( $_POST['billing_country'] ) ) {

              $validation_errors->add( 'billing_billing_country', __( 'Country is required.', 'woocommerce' ) );

       }
       if ( isset( $_POST['billing_state'] ) && empty( $_POST['billing_state'] ) ) {

              $validation_errors->add( 'billing_billing_state', __( 'State is required.', 'woocommerce' ) );

       }*/
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
/**
* Save the extra register fields.
*
* @paramint $customer_id Current customer ID.
*
* @return void
*/
function wooc_save_extra_register_fields( $customer_id ){

       if ( isset( $_POST['billing_first_name'] ) ) {
              // WordPress default first name field.
              update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
              // WooCommerce billing first name.
              update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        }
       if ( isset( $_POST['billing_last_name'] ) ) {
              // WordPress default last name field.
              update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
              // WooCommerce billing last name.
              update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
          }
       /*if ( isset( $_POST['billing_phone'] ) ) {
              // WooCommerce billing phone
              update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
       }
       if ( isset( $_POST['billing_company'] ) ) {
              // WooCommerce billing_company
              update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
       }
       if ( isset( $_POST['billing_postcode'] ) ) {
              // WooCommerce billing_postcode
              update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
       }
       if ( isset( $_POST['billing_address_1'] ) ) {
              // WooCommerce billing_address_1
              update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
       }
       if ( isset( $_POST['billing_address_2'] ) ) {
              // WooCommerce billing_address_2
              update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
       }
       if ( isset( $_POST['billing_city'] ) ) {
              // WooCommerce billing_city
              update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
       }
       if ( isset( $_POST['billing_state'] ) ) {
              // WooCommerce billing_state
              update_user_meta( $customer_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );
       }
       if ( isset( $_POST['billing_country'] ) ) {
              // WooCommerce billing_country
              update_user_meta( $customer_id, 'billing_country', sanitize_text_field( $_POST['billing_country'] ) );
       }*/
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

function shop_enqueue() {
      wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri() . '/js/shop-ajax-script.js', array('jquery') );
      wp_localize_script( 'ajax-script', 'shop_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'nonce' => wp_create_nonce('ajax-nonce') ) );
 }
add_action( 'wp_enqueue_scripts', 'shop_enqueue' );


add_action( 'wp_ajax_productprice_ajax_action', 'productprice_ajax_action' );
add_action( 'wp_ajax_nopriv_productprice_ajax_action', 'productprice_ajax_action' );

function productprice_ajax_action (){
    global $wpdb;
	/*if($_POST['variationid']>0){
		$product_id = $_POST['variationid'];
	}
	else{
		$product_id = $_POST['productid'];
	}*/
	$product = wc_get_product($_POST['productid']);
	$sale_price = $product->get_price();
	$quantity = $_POST['quantity'];
	
	$new_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price', $sale_price, $product, $quantity);
	$saveprice = ($sale_price - $new_price)*$quantity;
	if($saveprice>0){
		echo "You save <span>".get_woocommerce_currency()." ".$saveprice."</span>";
	}
	
  	//echo "<br />Product ID : ".$_POST['productid'];
	//echo "<br />Variation ID : ".$_POST['variationid'];
	//echo "<br />Quantity : ".$_POST['quantity'];
	
    wp_die();
}

//Filter WooCommerce Flexslider options - Add Navigation Arrows
 
add_filter( 'woocommerce_single_product_carousel_options', 'sf_update_woo_flexslider_options' );
/**
* Filer WooCommerce Flexslider options - Add Navigation Arrows
*/
function sf_update_woo_flexslider_options( $options ) {
 
    $options['directionNav'] = true;
 
    return $options;
}


add_action( 'woocommerce_before_single_product', 'woocommerce_template_single_meta', 10 );
do_action( 'woocommerce_product_meta_start' );
do_action( 'woocommerce_product_meta_end' );
add_action( 'woocommerce_before_single_product', 'woocommerce_template_single_title', 40 );

function ls_remove_default_woo_product_title() {
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
}
add_action( 'woocommerce_before_single_product', 'ls_remove_default_woo_product_title' );

add_filter( 'woocommerce_product_tabs', 'woo_aproduct_tab_count',1000 );
function woo_aproduct_tab_count( $tabs ) {	
	$total = count($tabs);
	if($total>0){
		$per = 100/$total;
		echo '<style>ul.wc-tabs li{width:'.$per.'%}</style>';
	}
	return $tabs;
}

function shop_script() { 
global $product;
if(isset($product)){
$title = $product->get_title();
?>
    <script type="text/javascript">
       jQuery(document).on('change', '.product form.variations_form .variations select', function(){
		var data = jQuery(this).val();
		var dataAttr = data.length ? jQuery(this).find('option[value="' + data + '"]').text() : '';
	
		var producttitle = "<?PHP echo $title;?>";
		var seloptions = "";
		jQuery(".product form.variations_form .variations select").each(function(){
			var data = jQuery(this).val();
			var dataAttr = data.length ? jQuery(this).find('option[value="' + data + '"]').text() : '';
			if(jQuery.trim(dataAttr)!=""){
				seloptions = seloptions + " - "+dataAttr ;
			}
		});
		if(seloptions!=""){
			jQuery(".product_title").html(producttitle+seloptions);
		}
	});
    </script>
	<?php
  }
}
add_action( 'wp_footer', 'shop_script' );

add_action( 'woocommerce_before_single_product', 'show_variation_sku_underneath_product_title' );
function show_variation_sku_underneath_product_title() {

    global $product;

    if ( $product->is_type('variable') ) {
        ?>
        <script>
        jQuery(document).ready(function($) {     
            $('input.variation_id').change( function(){
                if( '' != $('input.variation_id').val() ) {

                    jQuery.ajax( {

                        url: '<?php echo admin_url( 'admin-ajax.php'); ?>',
                        type: 'post',
                        data: { 
                            action: 'get_variation_sku', 
                            variation_id: $('input.variation_id').val()
                        },
                        success: function(data) {
                           // $('h1.product_title').siblings('.variation-sku').remove();
                            if(data.length > 0) {
                               // $('h1.product_title').after('<p class="variation-sku">Selected Varient SKU: ' + data + '</p>');
								jQuery("span.sku").html(data);
                            }
                        }
                    });

                }
            });
        });
        </script>
    <?php
    }
}
    
add_action('wp_ajax_get_variation_sku' , 'get_variation_sku');
add_action('wp_ajax_nopriv_get_variation_sku','get_variation_sku');
function get_variation_sku() {

    $variation_id = intval( $_POST['variation_id'] );
    $sku = '';

    if ( $product = wc_get_product( $variation_id ) ) $sku = $product->get_sku();
    echo $sku;

    wp_die(); // this is required to terminate immediately and return a proper response
}

register_nav_menus( array(
		'quote_request' => esc_html__( 'Quote Basket', 'ecomall' ),
	) );

if( !function_exists('ecomall_quote_basket_menu') ){
	function ecomall_quote_basket_menu(){
		if( has_nav_menu( 'quote_request' ) ){
			//do_action('ecomall_before_top_header_menu');
			wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'quote_request-menu', 'theme_location' => 'quote_request', 'depth' => 1 ) );
			//do_action('ecomall_after_top_header_menu');
		}
	}
}

add_action( 'admin_init', 'ucallm_remove_menu_pages' );

function ucallm_remove_menu_pages() {

    remove_menu_page( 'edit.php?post_type=ts_team' );
    remove_menu_page( 'post-new.php?post_type=ts_team' );
	
	remove_menu_page( 'edit.php?post_type=ts_testimonial' );
    remove_menu_page( 'post-new.php?post_type=ts_testimonial' );
}



/*Custom Post type start*/

function cw_post_type_partners() {

$supports = array(

'title', // post title

'editor', // post content

'author', // post author

'thumbnail', // featured images

'excerpt', // post excerpt

'custom-fields', // custom fields

'comments', // post comments

'revisions', // post revisions

'post-formats', // post formats

);

$labels = array(

'name' => _x('Partners', 'plural'),

'singular_name' => _x('Partners', 'singular'),

'menu_name' => _x('Partners', 'admin menu'),

'name_admin_bar' => _x('Partners', 'admin bar'),

'add_new' => _x('Add New', 'Add new'),

'add_new_item' => __('Add New Partner'),

'new_item' => __('New Partner'),

'edit_item' => __('Edit Partners'),

'view_item' => __('View Partners'),

'all_items' => __('All Partners'),

'search_items' => __('Search Partners'),

'not_found' => __('No partners found.'),

);

$args = array(

'supports' => $supports,

'labels' => $labels,

'public' => true,

'query_var' => true,

'rewrite' => array('slug' => 'partners'),

'has_archive' => true,

'hierarchical' => false,

);

register_post_type('partners', $args);

}

add_action('init', 'cw_post_type_partners');

/*Custom Post type end*/