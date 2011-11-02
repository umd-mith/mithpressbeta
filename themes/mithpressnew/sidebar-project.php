<div id="sidebar" class="project widget-area span-5 prepend-1 append-bottom last" role="complementary">

	<?php if ( ! dynamic_sidebar( 'project-sidebar' ) ) : ?>
        <?php if (function_exists('get_custom_field_data') ) {
			$website = get_custom_field_data('project-website', false); 
		 ?>
        <aside id="project-website" class="widget">
			<h3><?php _e( 'Project Website', 'mithpress' ); ?></h3>
			<p>View the website associated with this project
				<a href="<?php echo $website ?>" target="_blank" class="project-website">VIEW WEBSITE</a>
            </p>
		</aside>
        <?php } ?>

	<?php endif; // end sidebar widget area ?>

</div><!-- #secondary .widget-area -->