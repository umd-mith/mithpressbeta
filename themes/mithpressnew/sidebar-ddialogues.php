<div id="sidebar" class="ddialogues widget-area span-5 prepend-1 prepend-top-2 last" role="complementary">
        <aside id="podcast-downloads" class="widget">
			<h3><?php _e( 'Available Downloads', 'mithpress' ); ?></h3>
			<p>
            
            <?php $files = get_post_meta(get_the_ID(), 'pods-files', false);
foreach ($files as $att) {
    // show image
	echo '<p class="podcast-files">';
    echo wp_get_attachment_link($att);
	echo '</p>';
} ?>
            </p>
		</aside>
</div>