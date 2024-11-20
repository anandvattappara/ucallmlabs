<?php 
/* Template Name:Partner Details */ 
?>
<?php
get_header();

$theme_options = ecomall_get_theme_options();
$page_options = ecomall_get_page_options();

$extra_class = '';

$page_column_class = ecomall_page_layout_columns_class($page_options['ts_page_layout']);

$show_breadcrumb = ( !is_home() && !is_front_page() && $page_options['ts_show_breadcrumb'] );
$show_page_title = ( !is_home() && !is_front_page() && $page_options['ts_show_page_title'] );
if( $show_breadcrumb || $show_page_title ){
	$extra_class = 'show_breadcrumb_'.ecomall_get_theme_options('ts_breadcrumb_layout');
}

if( $theme_options['ts_prod_cat_border'] ){
	$extra_class .= ' border-default';
}
if( have_posts() ) the_post();
//ecomall_breadcrumbs_title($show_breadcrumb, $show_page_title, get_the_title());
?>
<div class="breadcrumb-title-wrapper breadcrumb-v1"><div class="breadcrumb-content"><div class="breadcrumb-title"><h1 class="heading-title page-title entry-title "><strong><?PHP the_title()?></strong></h1><div class="breadcrumbs"><div class="breadcrumbs-container"><a href="<?PHP echo home_url();?>">Home</a><span>/</span><a href="<?PHP echo home_url();?>/partners">Partners</a><span>/</span><?PHP the_title()?></div></div></div></div></div>
<div class="page-container">
	
	
	<!-- Main Content -->
	<div id="main-content" class="container">	
		<div id="primary" class="site-content">
		<?php 
			if( class_exists('WooCommerce') ){
				wc_print_notices();
			}
		?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="row">
				<?php 
					
					$ID = get_the_ID();
					?>
					<div class="col-md-8">
					<?PHP
					the_content();
					?>
					</div>
					<div class="col-md-4">
					<div class="partnerlogo"><?php echo get_the_post_thumbnail($ID, 'small-thumb',array('class' => 'img-fluid')); ?></div>
					<div class="partnetcontactbox">
					<h3><i class="far fa-user-circle"></i>YOU NEED ANY HELP?</h3>
					<div class="pinfo">
					<p><strong>Please Contact:</strong>
					<div class="row">
					<?PHP
					$userimage = get_post_meta( $ID, 'parner_image', true );
					if($userimage!=""){
					?>
					<div class="col-3"><img src="<?PHP echo $userimage; ?>" alt="user"  class="img-fluid partnerperson"/></div>
					<div class="col-9">
					<?PHP echo get_post_meta( $ID, 'partner_contact_person', true ) ?>
					<br>Tel: <?PHP echo get_post_meta( $ID, 'partner_phone', true ) ?>
					<br>Mail: <?PHP echo get_post_meta( $ID, 'partner_email', true ) ?>
					</div>
					<?PHP
					}
					else{
					?>
					<div class="col-12">
					<?PHP echo get_post_meta( $ID, 'partner_contact_person', true ) ?>
					<br>Tel: <?PHP echo get_post_meta( $ID, 'partner_phone', true ) ?>
					<br>Mail: <?PHP echo get_post_meta( $ID, 'partner_email', true ) ?>
					</div>
					<?PHP
					}
					?>
					</div>
					</p>
					</div>
					</div>
					</div>
				</div>
			</article>
		</div>
	</div>
	
	
</div>

<?php get_footer(); ?>