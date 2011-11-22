<?php 
/**
 * The template for displaying content in the single-people.php templates
 *
**/

 
?>
<?php 
    global $people_mb;
    // get the meta data for the current post
	$people_mb->the_meta();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">

        <div id="personal-info" class="append-bottom prepend-top clear">
			<?php the_post_thumbnail( 'bio-image' ); ?>
        	<h1 class="entry-title"><?php the_title(); ?></h1>
            <h2 class="info-title">
		<?php $people_mb->the_field('title'); ?>
		<?php echo $people_mb->the_value(); ?>
	</p>

            
            
            
            Staff Title</h2>
            <span class="info-email"><a href="mailto:#">email@domain.com</a></span>
            <span class="soc-twitter"><a href="#">@twit_handle</a></span>	
            <span class="info-phone">301.123.4567</span>	
        </div><!-- /#personal-info -->
        
        <div id="bio">
            <?php the_content(); ?>
        </div><!-- /#bio -->
        
        <div id="info-links" class="column left">
        <h2 class="column-title">Links</h2>
        <ul>
            <li><a href="#">Link One</a></li>
            <li><a href="#">Link One</a></li>
        </ul>
        </div><!-- /#info-links --> 

        <div id="blog-feed" class="column right">
            <h2><?php _e('Recent Posts from Personal Blog'); ?></h2>
            <?php // Get RSS Feed(s)
            include_once(ABSPATH . WPINC . '/feed.php');
            
            // Get a SimplePie feed object from the specified feed source.
            $rss = fetch_feed('http://smithsonianlibraries.si.edu/smithsonianlibraries/atom.xml');
            if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
                // Figure out how many total items there are, but limit it to 5. 
                $maxitems = $rss->get_item_quantity(5); 
            
                // Build an array of all the items, starting with element 0 (first element).
                $rss_items = $rss->get_items(0, $maxitems); 
            endif;
            ?>
            
            <ul>
                <?php if ($maxitems == 0) echo '<li>No recent posts.</li>';
                else
                // Loop through each feed item and display each item as a hyperlink.
                foreach ( $rss_items as $item ) : ?>
                <li>
                    <a href='<?php echo esc_url( $item->get_permalink() ); ?>'
                    title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
                    <?php echo esc_html( $item->get_title() ); ?><br />
                    <span class="post-date"><?php echo $item->get_date('j F Y'); ?></a>
                </li>
                <?php endforeach; ?>
            </ul>




        </div><!-- /#info-links --> 
        
	</div><!-- .entry-content -->

</article>
<!-- #post-<?php the_ID(); ?> -->