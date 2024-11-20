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
<style>
.ts-dimensions-content ul li > span:first-child, .woocommerce table.shop_attributes th, .woocommerce-tabs .panel table tr td:first-child {
        width: 15%;
    }
}
/* set the position of thumbnail images*/
.woocommerce div.product.gallery-layout-vertical.has-gallery div.images {
    padding-left: 135px;
}
.woocommerce-product-gallery.woocommerce-product-gallery--with-images.woocommerce-product-gallery--columns-4.images {
  display:flex;
column-gap: 14px;
    margin-bottom: 0;
 
}
div.product div.images.woocommerce-product-gallery .flex-viewport {
   flex-basis: 82%;
height:50px;
}
.woocommerce-js div.product div.images .flex-control-thumbs {
flex-basis: 18%;
width:300px;
}

/* Move the images on the Left side*/
.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images {
    flex-direction: row-reverse;
}

/* set the min width of thumbnail images*/
ol.flex-control-nav.flex-control-thumbs li {
min-width:100%;
}

/* Limit the thumbnail images to four images*/
.woocommerce-js div.product div.images .flex-control-thumbs {
overflow:hidden;
    zoom: 1;
   
}
ol.flex-control-nav.flex-control-thumbs {
max-height:540px !important;
margin:0px;
padding:0px;
width:300px;
	z-index: 991;
}
@media (max-width:670px){
ol.flex-control-nav.flex-control-thumbs {
max-height:350px !important;
}
.flex-viewport{min-height:350px !important; margin-bottom:30px;}
}
/* Set the direction of arrows*/
ul.flex-direction-nav {
    position: absolute;
height:560px;
    z-index: 1;
    width: 100%;
    left: 0;
    margin: 0;
    padding: 0px;
    list-style: none;
display:flex!important;
flex-direction:column!important;
justify-content: space-between;
display:none!important;
}
/* set position of previous arrow*/
li.flex-nav-prev { margin-top:-25px !important;
left:-5px !important;}
/* set position of next arrow*/
 
li.flex-nav-next{ margin-top:-25px !important;
left:-5px !important;}
 
a.flex-next {visibility:hidden!important;}
a.flex-prev {visibility:hidden!important;}
/* next arrow appear */
div.woocommerce-product-gallery .flex-direction-nav a.flex-next::after {
visibility:visible;content: '\f107';
font-family: 'Font Awesome 5 Free';
 
margin-top: 0px;
font-size: 20px;   
font-weight: bold;
}
/* previous arrow appear*/
a.flex-prev::before {
    visibility:visible;
    content: '\f106';
font-family: 'Font Awesome 5 Free';   
margin-top: 0px;
 
margin-left: 30px;
font-size: 20px;
font-weight: bold;
}
 
ul.flex-direction-nav li a {
color: #ccc;
}
 
ul.flex-direction-nav li a:hover {
text-decoration: none;
}
 
 
ul.flex-direction-nav li a:hover {
text-decoration: none;
}
.flex-control-nav{
top:0px;
}
div.woocommerce-product-gallery .flex-direction-nav .flex-prev {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #ffffff;
    color: #000000;
    font-size: 0;
    letter-spacing: 0;
    line-height: 0;
    text-align: center;
    position: absolute;
    top: 2%;
    left: 4%;
    transform: translateY(-50%);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    text-decoration: none;
}
div.woocommerce-product-gallery .flex-direction-nav .flex-next {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #ffffff;
    color: #000000;
    font-size: 0;
    letter-spacing: 0;
    line-height: 0;
    text-align: center;
    position: absolute;
    top:98%;
    left:5%;
    transform: translateY(-50%);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    text-decoration: none;
}
div.product div.images.woocommerce-product-gallery .flex-viewport {
    flex-basis: 82%;
}
.woocommerce div.product.gallery-layout-vertical div.images .flex-control-thumbs {
    flex-direction: row-reverse;
    position: absolute;
    top: 0;
    left: 0;
	max-width:18%;
}
.woocommerce div.product div.images .flex-control-thumbs {
    display: flex;
    flex-flow: row wrap;
    gap: 15px;
}
div.product div.images.woocommerce-product-gallery .flex-viewport {
    flex-basis: 100%;
}
.ts-dimensions-content ul{-webkit-border-radius: 6px;
-moz-border-radius: 6px;
border-radius: 6px; border:1px solid #ddd;}
.ts-dimensions-content ul li:first-child{-webkit-border-top-left-radius: 6px;
-webkit-border-top-right-radius: 6px;
-moz-border-radius-topleft: 6px;
-moz-border-radius-topright: 6px;
border-top-left-radius: 6px;
border-top-right-radius: 6px;}
.ts-dimensions-content ul li:last-child{
	-webkit-border-bottom-right-radius: 6px;
-webkit-border-bottom-left-radius: 6px;
-moz-border-radius-bottomright: 6px;
-moz-border-radius-bottomleft: 6px;
border-bottom-right-radius: 6px;
border-bottom-left-radius: 6px;}
#productqatable table{border-spacing: 0;
    border-collapse: separate;
    border-radius: 10px;
    border: 1px solid #ddd;}
</style>
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
   })
});

	/* scroll the images through images index*/
const updateCarousel = (selectedImgIndex, lastImgIndex) => {
    let indexOfImgToScroll = selectedImgIndex - 3;
    if (selectedImgIndex < 3 || lastImgIndex <= 3) indexOfImgToScroll = -1;
    else if (selectedImgIndex === lastImgIndex) indexOfImgToScroll = indexOfImgToScroll-1;
    
    document.querySelectorAll(".flex-control-thumbs li").forEach((li, i) => {
        if (i <= indexOfImgToScroll) li.style.marginTop= '-150px';
        else li.style.marginTop ='0';
        li.style.transition = 'all 0.4s linear';
    });
};

/* Mutation observer is used to keep the record of active images and change the image accordingly*/
document.addEventListener("DOMContentLoaded", (event) => {
    setTimeout(() => {
        let observer = new MutationObserver((mutations) => {
            mutations.forEach((mutationRecord) => {
                if (mutationRecord.target.className === "flex-active") {
                    const allElements = mutationRecord.target.parentNode.parentNode.children;
                    const targetedElement = mutationRecord.target.parentNode;
                    const indexOfTargetedElement = Array.from(allElements).indexOf(targetedElement);
                    const lastElementIndex = document.querySelectorAll(".flex-control-thumbs li").length - 1;
                    
                    updateCarousel(indexOfTargetedElement, lastElementIndex);
                }
            });
        });

        document.querySelectorAll(".flex-control-thumbs li img").forEach((img, i) => {
            observer.observe(img, {
                attributes: true,
                attributeFilter: ['style', 'class'],
            });
        });
    }, 0);
});

jQuery(document).ready(function(){
         jQuery(".ts-product-attribute").click(function(){
            jQuery('html, body').animate({
               scrollTop: jQuery(".price").offset().top
            }, 1000);
         });
      });
	
jQuery(document).ready(function() {
    jQuery( '.variations_form' ).on( 'change', '.variation_id', function() {
        // Get the selected variation ID
        var variation_id = jQuery(this).val();
		jQuery(".oembtn").show();
    });
});
</script>
