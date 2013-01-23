<?php if ( is_single() ) { ?>
<div id="sidebar" class="blog widget-area span-5 prepend-top-2 append-bottom last" role="complementary">
<?php } else { ?>
<div id="sidebar" class="blog widget-area span-5 append-bottom last" role="complementary">
<?php } ?>

  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar') ); ?>

</div>