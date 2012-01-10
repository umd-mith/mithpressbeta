<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Basic Sidebar Widgets
- Recent Posts Widget

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Basic Sidebar Widgets */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_sidebars') )
    register_sidebar(array(
        'name' => 'Blog Sidebar',
		'id' => 'blog',
		'description' => 'Sidebar displayed on blog pages',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));
    register_sidebar(array(
        'name' => 'Podcast Sidebar',
		'id' => 'podcast',
		'description' => 'Sidebar displayed on inasideidual podcast page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));
    register_sidebar(array(
        'name' => 'Digital Dialogues Sidebar',
		'id' => 'ddialouges',
		'description' => 'Sidebar displayed on main Digital Dialogues page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));
    register_sidebar(array(
        'name' => 'Footer Widget Area',
		'id' => 'footerwidgets',
		'description' => 'footer area widgets',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));


/*-----------------------------------------------------------------------------------*/
/* Recent Posts Widgets */
/*-----------------------------------------------------------------------------------*/

class Recentposts_thumbnail extends WP_Widget {

    function Recentposts_thumbnail() {
        parent::WP_Widget(false, $name = 'Recent Posts Widget');
    }

    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
            <?php echo $before_widget; ?>
            <?php if ( $title ) { 
				echo $before_title . '<a href="';
				echo ( get_option('feedburner_url') )? get_option('feedburner_url') : get_bloginfo('rss2_url');
				echo '" class="rss">&nbsp;</a>' . $title . $after_title; 
			} else echo '<div class="widget-body clear">'; ?>

            <?php
                global $post;
                if (get_option('rpost_qty')) $rpost_qty = get_option('rpost_qty'); else $rpost_qty = 5;
                $q_args = array(
                    'numberposts' => $rpost_qty,
                );
                $rpost_posts = get_posts($q_args);
				echo '<ul id="blog-feed">';
                foreach ( $rpost_posts as $post ) :
                    setup_postdata($post); ?>
                <li>
                <a href="<?php the_permalink(); ?>" class="rpost clear">
                    <?php if ( has_post_thumbnail() && !get_option('rpost_thumb') ) {
                        the_post_thumbnail('mini-thumbnail');
                    }
                    ?>
                    <span class="rpost-title"><?php the_title(); ?></span>
                    <span class="rpost-date"><?php the_time(__('M j, Y')) ?></span>
                </a>
                </li>
            <?php endforeach; ?>
            </ul>

            <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        update_option('rpost_qty', $_POST['rpost_qty']);
        update_option('rpost_thumb', $_POST['rpost_thumb']);
        return $instance;
    }

    function form($instance) {
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="rpost_qty">Number of posts:  </label><input type="text" name="rpost_qty" id="rpost_qty" size="2" value="<?php echo get_option('rpost_qty'); ?>"/></p>
            <p><label for="rpost_thumb">Hide thumbnails:  </label><input type="checkbox" name="rpost_thumb" id="rpost_thumb" <?php echo (get_option('rpost_thumb'))? 'checked="checked"' : ''; ?>/></p>
        <?php
    }

}
add_action('widgets_init', create_function('', 'return register_widget("Recentposts_thumbnail");'));
