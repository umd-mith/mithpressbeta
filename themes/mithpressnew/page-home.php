<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
			<div id="content" role="main" class="span-16 last">
<!-- start slideshow -->
				<?php get_template_part( 'slider', 'home' ); ?>
<!-- end slideshow / start twitter feed -->
		<div id="twitter_wrap"></div>

<!-- end twitter feed / start page content -->



			</div>
<!--end page content-->
		</div>
<!-- end #primary -->
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>