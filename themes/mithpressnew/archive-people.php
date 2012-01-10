<?php
/**
 * The template for displaying People Archive page.
*/

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
        <!--start subnav -->
        <?php get_sidebar('left'); ?>
        <!-- end subnav sidebar / start archive content -->
			<div id="content" role="main" class="archive span-16 last">
			
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
            <div class="people-section"><?php include('people/people-directors.php'); ?></div>
			<div class="people-section"><?php include('people/people-finance.php'); ?></div>
			<div class="people-section"><?php include('people/people-staff.php'); ?></div>
			<div class="people-section"><?php include('people/people-rassoc.php'); ?></div>
			<div class="people-section"><?php include('people/people-fellows.php'); ?></div>
        </div>
        <!-- end #content -->
	</div>
<div class="clear"></div>
<!-- end #primary -->
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>