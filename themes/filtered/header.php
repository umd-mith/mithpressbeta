<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>	
</head>

<body <?php body_class(); ?> >

<div id="container" class="clearfix">	
<div id="header">
	<div class="inside clearfix">			
		<?php $ttrust_logo = ttrust_get_option('ttrust_logo'); ?>
		<div id="mainNav">							
			<?php wp_nav_menu( array('menu_class' => 'sf-menu', 'theme_location' => 'main', 'fallback_cb' => 'default_nav' )); ?>			
		</div>
		<div id="logo">
		<?php if($ttrust_logo) : ?>				
			<h1 class="logo"><a href="<?php bloginfo('url'); ?>"><img src="<?php echo $ttrust_logo; ?>" alt="<?php bloginfo('name'); ?>" /></a></h1>
		<?php else : ?>				
			<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>				
		<?php endif; ?>	
		</div>		
		
	</div>		
</div>

<?php if(is_front_page()):?>
	<?php $ttrust_home_message = ttrust_get_option('ttrust_home_message'); ?>
	<?php $ttrust_slideshow_enabled = ttrust_get_option('ttrust_slideshow_enabled'); ?>
	
	<?php if($ttrust_slideshow_enabled) include( TEMPLATEPATH . '/includes/slideshow.php'); ?>
	
	<?php if($ttrust_home_message) : ?>				
		<div id="homeMessage" <?php if(!$ttrust_slideshow_enabled) echo 'class="topBorder"'; ?>><p><?php echo $ttrust_home_message ?></p></div>
	<?php endif; ?>
<?php endif; ?>