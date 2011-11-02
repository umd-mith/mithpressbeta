<?php
/**
 * @package WordPress
 * @subpackage MITH_v3
 */
 
 /*
 Template Name: Jobs
 */
 
 $url = get_bloginfo('url');
 
	if ($post->post_parent)	{
		$ancestors=get_post_ancestors($post->ID);
		$root=count($ancestors)-1;
		$parent = $ancestors[$root];
		$parent = get_post($parent);
		$parent_title = $parent->post_title;
		$parent_link = $parent->post_name;
		$breadcrumbs[] = "<a href=\"$url/$parent_link\">$parent_title</a>\n";		
	}
	$parent_title = $post->post_title;
	$parent_link = $post->post_name;
	$breadcrumbs[] = "<a href=\"$url/$parent_link\">$parent_title</a>\n";	
?>

<?php include (TEMPLATEPATH . "/header.php"); ?>

<ul class="profiles">
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_nfraistat.jpg" alt="Neil Fraistat" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_mkirschenbaum.png" alt="Matthew Kirschenbaum" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_dreside.png" alt="Doug Reside" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_milton.jpg" alt="Milton" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_tclement.jpg" alt="Tanya Clement" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_hdevinney.jpg" alt="helen DeVinney" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_gdickie.jpg" alt="Grant Dickie" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_rdonahue.jpg" alt="Rachel Donahue" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_cgrogan.jpg" alt="Christina Grogan" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_ekvernen.jpg" alt="Elisabeth Kvernen" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_jneal.png" alt="James Neal" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_tnguyen.png" alt="TinTin Nguyen" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_kpatil.jpg" alt="Ketan Patil" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_aquinn.png" alt="Alex Quinn" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_fhildy.jpg" alt="Frank Hildy" /></li>
	<li><img src="<?php bloginfo('url'); ?>/wp-content/uploads/staff_lsmiley.png" alt="Leigh Wilson Smiley" /></li>
	<div class="clear"></div>
</ul>


<div class="main">
	
		<div id="content" class="narrowcolumn" role="main">
	
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post_page" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
				<div class="entry">
					<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	
				</div>
			</div>
			<?php endwhile; endif; ?>
			<div class="clear"></div>
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
		</div>
		
</div>

<div id="sidebar">
	<h3>Available Positions:</h3>
  
  <ul>
	<li><h2><a href="http://mith.umd.edu/about/jobs/associate-director-mith-assistant-dean-for-digital-humanities-research-libraries/">Associate Director, MITH; Assistant Dean for Digital Humanities Research, Libraries</a></h2></li>
	<p>A joint appointment between MITH and the UMD libraries, this position bears primary responsibility for overseeing the UMD libraries strategic engagement with digital humanities collections and research; develop research collaborations between the Libraries, MITH, and other partners; write grants for both the Libraries and MITH; and oversee MITH’s data curation practices.</p></li>
  </ul>

  <ul>
	<li><p>We're eager to hear from those who may be interested in future positions as they become available. Feel free to share your CV with us, <a href="mailto:mith@umd.edu">mith@umd.edu</a></p></li>
  </ul>    

  <!-- <ul>
    <li><h2><a href="http://mith.umd.edu/about/jobs/software-architectlead-developer/">Software Architect/Lead Developer</a></h2>
  <p>Seeking an experienced developer and software architect to lead the technical direction of all MITH software projects. In other words, we're looking for someone with ninja coding skills who can continue professionalizing our agile development process.</p>
    </li>

  <li><h2><a href="http://mith.umd.edu/about/jobs/software-developer-research-development/">Software Developer, Research &amp; Development</a></h2>
  <p>This research and development programmer will focus on building shareable and reusable tools to manage and analyze large bodies of "diggable data," or structured text. Looking for someone creative and experienced to prototype future funded work.</p>
  </li>
  <li><h2><a href="http://mith.umd.edu/about/jobs/program-coordinator/">Project Coordinator</a></h2>
  <p>Coordinating project activities for the Mellon-funded Project Bamboo's Corpora Space, this position will involve working with partners across the country to organize a series of workshops and white papers related to the project.</p>
  </li>
</ul> -->
</div>

<?php get_footer(); ?>