<?php
/**
 * The template for displaying People Archive page.
*/

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">

        <?php get_sidebar('left'); ?>
        <!-- /subnav sidebar -->

        <div id="content" role="main" class="archive span-16 last">
        
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

			<?php 
                global $people_mb;
                $people_mb->the_meta();
                $args = array(
                    'meta_key' => $people_mb->get_the_name('lname'),
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'staffgroup',
                            'field' => 'slug',
                            'terms' => array( 'archive' ),
                        )
                    )
                );
                query_posts( $args );
                ?>
            
            <?php if ( have_posts() ) : ?>
                        
                <?php 
				global $people_mb;
                $people_mb->the_meta(); ?>
            
                <header class="page-header">
                    <h1 class="page-title append-bottom">Past Staff</h1>
                </header>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'people-archive'); ?>

				<?php endwhile; ?>
			
            
			<?php endif; ?>
			<?php wp_reset_query(); ?>
                    
		</div>
        <!-- /content -->
	</div>
    <!--/primary/post -->    
<div class="clear"></div>
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>