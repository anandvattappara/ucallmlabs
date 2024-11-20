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

//ecomall_breadcrumbs_title($show_breadcrumb, $show_page_title, get_the_title());
?>
<div class="breadcrumb-title-wrapper breadcrumb-v1"><div class="breadcrumb-content"><div class="breadcrumb-title"><h1 class="heading-title page-title entry-title "><strong>Partners</strong></h1><div class="breadcrumbs"><div class="breadcrumbs-container"><a href="<?PHP echo home_url();?>">Home</a><span>/</span>Partners</div></div></div></div></div>

<div class="page-container">
	
	
	<!-- Main Content -->
	<div id="main-content">	
		<div id="primary" class="site-content">
		<?php 
			if( class_exists('WooCommerce') ){
				wc_print_notices();
			}
		?>
			
			<div class="container">
			<div class="e-con-inner">
			<?php 
  $args = array(
      'post_type' => 'partners',
      'post_status' => 'publish',
	   'orderby' => 'post_title',
	   'order' => 'asc',
  ); 
  $pages = get_posts($args); 
  $templetter = "";
  
   ?>
  <div class="row partnetslist">
 <ul class="partnersindex">
 <?PHP
 for ($x = ord('a'); $x <= ord('z'); $x++){
 	$iletter = strtoupper(chr($x));
	echo '<li><a href="#'.$iletter.'">'.$iletter.'</a></li>';
 }
 ?>
 </ul>
  <?php foreach( $pages as $page ) { 
  $firstletter = strtolower(substr($page->post_title,0,1));
  if($templetter != $firstletter){
 	echo '<div class="partnetletter" id="'.strtoupper($firstletter).'">'.strtoupper($firstletter).'</div>'; 
  }
  ?>
   <div class="col-md-3"><a href="<?php echo  get_permalink($page->ID); ?>"  title="<?php echo $page->post_title; ?>"><?php echo get_the_post_thumbnail($page->ID, 'small-thumb',array('class' => 'img-fluid')); ?></a></div>
   <div class="col-md-4"><a href="<?php echo  get_permalink($page->ID); ?>"  title="<?php echo $page->post_title; ?>" class="partnertitle"><?php echo $page->post_title; ?></a></div>
   <div class="col-md-5"><p><?PHP echo strip_tags($page->post_excerpt); ?></p></div>
   <div class="col-12 parnerborbot"></div>
  <?php
  $templetter = $firstletter;
   } ?>
  </div>
		</div>
		</div>
		</div>
	</div>
	
	
	
</div>

<?php get_footer(); ?>