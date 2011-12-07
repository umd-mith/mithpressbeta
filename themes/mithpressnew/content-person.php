<?php 
/**
 * The template for displaying content in the single-people.php templates
 *
**/
    global $people_mb;
	$people_mb->the_meta();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">

        <div id="personal-info" class="append-bottom prepend-top clear">
			<?php the_post_thumbnail( 'bio-image' ); ?>
        	<h1 class="entry-title"><?php the_title(); ?></h1>
            <h2 class="info-title"><?php echo $people_mb->the_value('title'); ?></h2>
            
			<?php $email = $people_mb->get_the_value('email');
			if ( $email != '') { ?>
            <span class="info-email"><a href="mailto:<?php echo $email ?>" rel="nofollow"><?php echo $email ?></a></span>
            <?php } 
			$twit = $people_mb->get_the_value('twitter');
			if ( $twit != '') { ?>
            <span class="info-twitter"><a href="http://www.twitter.com/#!/<?php echo $twit ?>" rel="nofollow" target="_blank">@<?php echo $twit ?></a></span>	
            <?php } 
			$phone = $people_mb->get_the_value('phone');
			if ( $phone != '') { ?>
            <span class="info-phone"><?php echo $phone ?></span>
            <?php } ?>
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

		<?php $blogrss = $people_mb->get_the_value('blogrss');
			if ( $blogrss != '') { ?>
        <div id="personal-blog-feed" class="column right">
            <h2><?php _e('Personal Blog Posts'); ?></h2>
            <?php // Get RSS Feed(s)
            include_once(ABSPATH . WPINC . '/feed.php');
            
            // Get a SimplePie feed object from the specified feed source.
			$blogrss = $people_mb->get_the_value('blogrss');
            $rss = fetch_feed( $blogrss );
            if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
                // Figure out how many total items there are, but limit it to 5. 
                $maxitems = $rss->get_item_quantity(5); 
            
                // Build an array of all the items, starting with element 0 (first element).
                $rss_items = $rss->get_items(0, $maxitems); 
            endif;
            ?>
            
            <ul id="blog-feed">
                <?php if ($maxitems == 0) echo '<li>No recent posts.</li>';
                else
                // Loop through each feed item and display each item as a hyperlink.
                foreach ( $rss_items as $item ) : ?>
                <li><a href="<?php echo esc_url( $item->get_permalink() ); ?>"
                    title="Permanent Link to <?php echo esc_html( $item->get_title() ); ?>" class="rpost clear" target="_blank">
                    <span class="rpost-title"><?php echo esc_html( $item->get_title() ); ?></span>
                    <span class="rpost-date"><?php echo $item->get_date('M j, Y'); ?></span>
				</a></li>
                <?php endforeach; ?>
            </ul>
            <div id="blog-more">
            	<?php $blogcat = $people_mb->get_the_value('blogcat'); ?>
                <a href="<?php echo $blogcat ?>" target="_blank" class="clear readmore">Read More</a>
            </div>
        </div><!-- /#blog-feed --> 
        <?php } ?>
        
	</div><!-- .entry-content -->
    <br clear="all" />
	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article>
<!-- #post-<?php the_ID(); ?> -->