<?php
/**
 * @package WordPress
 * @subpackage MITH_v3
 */
/*
Template Name: Staff
*/
?>
<?php
	$parent = $post->post_title;
	$parentlink = $post->post_name;
	$url = get_bloginfo('url');
	$breadcrumbs[] = "<a href=\"$url/$parentlink\">$parent</a>\n";		
?>

<?php include (TEMPLATEPATH . "/header.php"); ?>

<div id="page-container">
<div id="page" class="width-limit">
	<?php get_sidebar('left'); ?>
    <div id="content" class="span-16 last">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2 class="append-bottom prepend-top"><?php the_title(); ?></h2>
			<div class="entry">
	
	<?php
	//$members_current = $wpdb->get_results("SELECT * FROM wp_mth_staff WHERE mth_s_status = 'current' ORDER BY mth_s_group=\"c\", mth_s_group=\"p\", mth_s_group=\"s\", mth_s_group=\"d\", mth_s_last ASC", ARRAY_A);
	$members_current = $wpdb->get_results("SELECT * FROM wp_mth_staff WHERE mth_s_status = 'current' AND mth_s_group = 'd' ORDER BY mth_s_order, mth_s_last", ARRAY_A);
	?>
	
	<h3 class="staff_heading">Directors</h3>
	<ul class="staff">
			
	<?php
    foreach ($members_current as $member) :
    ?>
    
    	<li class="staff-member">
    		<a name="<?php echo strtolower($member['mth_s_first'].$member['mth_s_last']); ?>"></a>
    		<a href="<?php get_bloginfo('site_url'); ?>/staff/<?php echo strtolower($member['mth_s_first'].$member['mth_s_last']); ?>" style="float: left">
            <img class="staff_img" src="<?php bloginfo('url'); ?>/wp-content/uploads/<?= $member['mth_s_img'] ?>" alt="<?php echo $member['mth_s_first']." ".$member['mth_s_middle']." ".$member['mth_s_last']; ?>" />
			<div class="staff_profile">
				<h4><?php echo $member['mth_s_first']." ".$member['mth_s_middle']." ".$member['mth_s_last']; ?></h4>
				<h5><?php echo $member['mth_s_title']; ?><!--  | Email: <?php echo stripslashes($member['mth_s_email']); ?> | Twitter handle: <?php echo stripslashes($member['mth_s_twitter']); ?> --></h5>
			</div>
            </a>
		</li>
		
    <?php
    endforeach;
	?>
		
	</ul>
	
	<h3 class="staff_heading">Staff</h3>
	<ul class="staff">
			
	<?php
	$members_current = $wpdb->get_results("SELECT * FROM wp_mth_staff WHERE mth_s_status = 'current' AND (mth_s_group = 's' OR mth_s_group='b' OR mth_s_group='r' OR mth_s_group='p') ORDER BY mth_s_last ASC", ARRAY_A);
    foreach ($members_current as $member) :
    ?>
    
    	<li class="staff-member">
    		<a name="<?php echo strtolower($member['mth_s_first'].$member['mth_s_last']); ?>"></a>
    		<img class="staff_img" src="<?php bloginfo('url'); ?>/wp-content/uploads/<?= $member['mth_s_img'] ?>" alt="<?php echo $member['mth_s_first']." ".$member['mth_s_middle']." ".$member['mth_s_last']; ?>" />
			<div class="staff_profile">
				<h4><?php echo $member['mth_s_first']." ".$member['mth_s_middle']." ".$member['mth_s_last']; ?></h4>
				<h5><?php echo $member['mth_s_title']; ?></h5>
				<!--<p><?php echo stripslashes($member['mth_s_bio']); ?></p>-->
			</div>
			<div class="clear"></div>
		</li>
		
    <?php
    endforeach;
	?>
		
	</ul>
	
	<h3 class="staff_heading">Resident Fellows</h3>
	<ul class="staff">
			
	<?php
	$members_current = $wpdb->get_results("SELECT * FROM wp_mth_staff WHERE mth_s_status = 'current' AND mth_s_group = 'f' ORDER BY mth_s_last ASC", ARRAY_A);
    foreach ($members_current as $member) :
    ?>
    
    	<li class="staff-member">
    		<a name="<?php echo strtolower($member['mth_s_first'].$member['mth_s_last']); ?>"></a>
    		<img class="staff_img" src="<?php bloginfo('url'); ?>/wp-content/uploads/<?= $member['mth_s_img'] ?>" alt="<?php echo $member['mth_s_first']." ".$member['mth_s_middle']." ".$member['mth_s_last']; ?>" />
			<div class="staff_profile">
				<h4><?php echo $member['mth_s_first']." ".$member['mth_s_middle']." ".$member['mth_s_last']; ?></h4>
				<h5><?php echo $member['mth_s_title']; ?></h5>
				<!--<p><?php echo stripslashes($member['mth_s_bio']); ?></p>-->
			</div>
			<div class="clear"></div>
		</li>
		
    <?php
    endforeach;
	?>
		
	</ul>

</div>
<!--<div id="sidebar">
	<ul>
		<li>
			<h3>Questions? Comments?</h3>
			<p>For general inquiries, please feel free to contact MITH via the link below.</p>
			<p><a class="sidebar_button" href="<?php bloginfo('url'); ?>/contact">Contact MITH</a></p>
			<p class="clear"></p>
		</li>
	</ul>
	
			<?php
		$kids = get_children('post_parent='.$post->ID);
		if (($post->post_parent) || ($kids)): ?>
		<ul id="subpages" role="navigation">
			<li><h2>Related Pages</h2>
			<ul>
			<?php
				if ($post->post_parent) {
					//wp_list_pages('title_li=&include='.$post->post_parent);
					wp_list_pages('title_li=&child_of='.$post->post_parent);
				} else {
					//wp_list_pages('title_li=&include='.$post->ID);
					wp_list_pages('title_li=&child_of='.$post->ID);
				}
			?>
			</ul>
			</li>
		</ul>
		<?php endif; ?>
		
	
	<ul>
		<li class="staff"><h2>Directors</h2>
		
			<?php
			$directors = $wpdb->get_results("SELECT mth_s_id,mth_s_first,mth_s_middle,mth_s_last,mth_s_title FROM wp_mth_staff WHERE mth_s_status = 'current' AND mth_s_group = 'd' ORDER BY mth_s_order, mth_s_last", ARRAY_A);
			?>
	
			<ul class="staff_sidebar">
			
			<?php
			foreach ($directors as $director) :
			?>
			
				<li>
					<a href="#<?php echo strtolower($director['mth_s_first'].$director['mth_s_last']); ?>" style="float: left"><?php echo $director['mth_s_first']." ".$director['mth_s_middle']." ".$director['mth_s_last']; ?></a>
					<small class="staff_title"><?php echo $director['mth_s_title']; ?></small>
					<div class="clear"></div>
				</li>
				
			<?php
			endforeach;
			?>
				
			</ul>
		</li>
		
		<li class="staff">
			<h2>Finance and Administration</h2>

			<?php
			$finances = $wpdb->get_results("SELECT mth_s_id,mth_s_first,mth_s_middle,mth_s_last,mth_s_title FROM wp_mth_staff WHERE mth_s_status = 'current' AND mth_s_group = 'b' ORDER BY mth_s_order, mth_s_last", ARRAY_A);
			?>
	
			<ul class="staff_sidebar">
			
			<?php
			foreach ($finances as $finance) :
			?>
			
				<li>
					<a href="#<?php echo strtolower($finance['mth_s_first'].$finance['mth_s_last']); ?>" style="float: left"><?php echo $finance['mth_s_first']." ".$finance['mth_s_middle']." ".$finance['mth_s_last']; ?></a>
					<small class="staff_title"><?php echo $finance['mth_s_title']; ?></small>
					<div class="clear"></div>
				</li>
				
			<?php
			endforeach;
			?>
				
			</ul>			
		</li>
		
		<li class="staff">
			<h2>Staff</h2>
		
			<?php
			$staffers = $wpdb->get_results("SELECT mth_s_id,mth_s_first,mth_s_middle,mth_s_last,mth_s_title FROM wp_mth_staff WHERE mth_s_status = 'current' AND mth_s_group = 's' ORDER BY mth_s_last ASC", ARRAY_A);
			?>
	
			<ul class="staff_sidebar">
			
			<?php
			foreach ($staffers as $staffer) :
			?>
			
				<li>
					<a href="#<?php echo strtolower($staffer['mth_s_first'].$staffer['mth_s_last']); ?>" style="float: left"><?php echo $staffer['mth_s_first']." ".$staffer['mth_s_middle']." ".$staffer['mth_s_last']; ?></a>
					<small class="staff_title"><?php echo $staffer['mth_s_title']; ?></small>
					<div class="clear"></div>
				</li>
				
			<?php
			endforeach;
			?>
				
			</ul>			
		
		</li>
		<li class="staff">
			<h2>Research Associates</h2>
		
			<?php
			$fellows = $wpdb->get_results("SELECT mth_s_id,mth_s_first,mth_s_middle,mth_s_last,mth_s_title FROM wp_mth_staff WHERE mth_s_status = 'current' AND mth_s_group = 'r' ORDER BY mth_s_last ASC", ARRAY_A);
			?>
	
			<ul class="staff_sidebar">
			
			<?php
			foreach ($fellows as $fellow) :
			?>
			
				<li>
					<a href="#<?php echo strtolower($fellow['mth_s_first'].$fellow['mth_s_last']); ?>" style="float: left"><?php echo $fellow['mth_s_first']." ".$fellow['mth_s_middle']." ".$fellow['mth_s_last']; ?></a>
					<small class="staff_title"><?php echo $fellow['mth_s_title']; ?></small>
					<div class="clear"></div>
				</li>
				
			<?php
			endforeach;
			?>
				
			</ul>
			
		</li>
		<li class="staff">
			<h2>Resident Fellows</h2>
		
			<?php
			$fellows = $wpdb->get_results("SELECT mth_s_id,mth_s_first,mth_s_middle,mth_s_last,mth_s_title FROM wp_mth_staff WHERE mth_s_status = 'current' AND mth_s_group = 'f' ORDER BY mth_s_last ASC", ARRAY_A);
			?>
	
			<ul class="staff_sidebar">
			
			<?php
			foreach ($fellows as $fellow) :
			?>
			
				<li>
					<a href="#<?php echo strtolower($fellow['mth_s_first'].$fellow['mth_s_last']); ?>" style="float: left"><?php echo $fellow['mth_s_first']." ".$fellow['mth_s_middle']." ".$fellow['mth_s_last']; ?></a>
					<small class="staff_title"><?php echo $fellow['mth_s_title']; ?></small>
					<div class="clear"></div>
				</li>
				
			<?php
			endforeach;
			?>
				
			</ul>
			
		</li>
		<li class="staff">
			<h2>Program Associates</h2>
		
			<?php
			$gas = $wpdb->get_results("SELECT mth_s_id,mth_s_first,mth_s_middle,mth_s_last,mth_s_title FROM wp_mth_staff WHERE mth_s_status = 'current' AND mth_s_group = 'p' ORDER BY mth_s_last ASC", ARRAY_A);
			?>
	
			<ul class="staff_sidebar">
			
			<?php
			foreach ($gas as $ga) :
			?>
			
				<li>
					<a href="#<?php echo strtolower($ga['mth_s_first'].$ga['mth_s_last']); ?>" style="float: left"><?php echo $ga['mth_s_first']." ".$ga['mth_s_middle']." ".$ga['mth_s_last']; ?></a>
					<small class="staff_title"><?php echo $ga['mth_s_title']; ?></small>
					<div class="clear"></div>
				</li>
				
			<?php
			endforeach;
			?>
				
			</ul>
			
		</li>

		<p class="clear"></p>
	</ul>	
	<ul>
		<li>
			<h3>MITH's History</h3>
			<p>Looking for MITH's former staff or associates?  Browse MITH's staff records via the link below.</p>
			<p><a class="sidebar_button" href="<?php bloginfo('url'); ?>/mithstaff/history">MITH's History</a></p>
			<p class="clear"></p>
		</li>
	</ul>
</div>
-->

			</div>
		</div>
		<?php endwhile; endif; ?>
    </div>
<!--end page content-->
</div>
<div class="clear"></div>
</div>
<!-- end page / start footer -->
<?php get_footer(); ?>