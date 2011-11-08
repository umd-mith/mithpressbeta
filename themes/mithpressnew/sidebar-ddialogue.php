<div id="sidebar" class="ddialogue widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('podcast') ); ?>

    <aside id="podcast-downloads" class="widget widget_downloads">
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