<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); 

$theme_options = ecomall_get_theme_options();

$extra_class = '';
$page_column_class = ecomall_page_layout_columns_class($theme_options['ts_prod_layout']);

$show_breadcrumb = $theme_options['ts_prod_breadcrumb'];
$show_page_title = $theme_options['ts_prod_title'];
if( $show_breadcrumb || $show_page_title ){
	$extra_class = 'show_breadcrumb_'.$theme_options['ts_breadcrumb_layout'];
}

if( $theme_options['ts_prod_cat_border'] ){
	$extra_class .= ' border-default';
}

ecomall_breadcrumbs_title($show_breadcrumb, $show_page_title, get_the_title());

?>
<div class="page-container <?php echo esc_attr($extra_class) ?> <?php echo esc_attr($page_column_class['main_class']); ?>">
	
	<!-- Left Sidebar -->
	<?php if( $page_column_class['left_sidebar'] ): ?>
		<div id="left-sidebar" class="ts-sidebar">
			<aside>
			<?php if( is_active_sidebar($theme_options['ts_prod_left_sidebar']) ): ?>
				<?php dynamic_sidebar( $theme_options['ts_prod_left_sidebar'] ); ?>
			<?php endif; ?>
			</aside>
		</div>
	<?php endif; ?>
	
	<div id="main-content">	
		<div id="primary" class="site-content">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
<section class="related products">
<h2>Customer Reviews</h2>
<?PHP
	echo do_shortcode('[cusrev_all_reviews sort="DESC" sort_by="date" per_page="10" number="-1" show_summary_bar="true" show_products="true" categories="" product_tags="" tags="" products="current" shop_reviews="true" number_shop_reviews="-1" inactive_products="false" show_replies="false" show_more="5" min_chars="0" avatars="initials" users="all" add_review="true"]');
?>
</section>
		</div>
	</div>
	
	<!-- Right Sidebar -->
	<?php if( $page_column_class['right_sidebar'] ): ?>
		<div id="right-sidebar" class="ts-sidebar">
			<aside>
				<?php if( is_active_sidebar($theme_options['ts_prod_right_sidebar']) ): ?>
					<?php dynamic_sidebar( $theme_options['ts_prod_right_sidebar'] ); ?>
				<?php endif; ?>
			</aside>
		</div>
	<?php endif; ?>
	
</div>
<?php get_footer(); ?>
<script language="javascript">
jQuery(".option").click(function(){
	var varienttype = jQuery(this).data("value");
	if(varienttype =='OEM' || varienttype =='ODM'){
		jQuery(".number-button").hide();
		jQuery(".single_add_to_cart_button").hide();
		jQuery(".variations tr:gt(0)").hide();
		jQuery(".oembtn").show();
		jQuery(".slidedesc").hide();
		jQuery(".slidecontainer").hide();
		jQuery(".price").hide();
	}
	else{
		jQuery(".number-button").show();
		jQuery(".single_add_to_cart_button").show();
		jQuery(".variations tr").show();
		jQuery(".oembtn").hide();
		jQuery(".slidedesc").show();
		jQuery(".slidecontainer").show();
		jQuery(".price").show();
	}
	
	
	
});

jQuery(document).ready(function() {
   jQuery("#quantityRange").attr("min",jQuery(".qty").attr("min"));
   jQuery("#quantityRange").attr("max",jQuery(".qty").attr("max"));
   jQuery("#quantityRange").attr("value",1);
   
   jQuery(".qty").change(function(){
   		jQuery("#quantityRange").attr("min",jQuery(".qty").attr("min"));
		jQuery("#quantityRange").attr("max",jQuery(".qty").attr("max"));
		 /*jQuery.ajax({
             type : "GET",
             dataType : "json",
             url : "/wp-admin/admin-ajax.php",
             data : {action: "get_shopdata"},
             success: function(response) {

                   alert("Your vote could not be added");
                   alert(response);
                }
        }); */
   })
});
</script>
