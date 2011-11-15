<div id="sidebar" class="people widget-area span-5 prepend-1 append-bottom last" role="complementary">

	<?php if ( ! dynamic_sidebar( 'people-sidebar' ) ) : ?>
        <aside id="" class="widget">
			<h3><?php _e( 'People Sidebar', 'mithpress' ); ?></h3>
			<p>Sidebar for staff pages goes here            </p>
		</aside>
	<?php endif; // end sidebar widget area ?>

</div><!-- #secondary .widget-area -->