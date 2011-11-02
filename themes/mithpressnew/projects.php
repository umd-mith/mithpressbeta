<?php
/**
 * @package WordPress
 * @subpackage MITH_v3
 */
/*
Template Name: Projects
*/
?>

<?php 

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
	
	if ($_GET['project']) {
		$project = $wpdb->get_row($wpdb->prepare("SELECT * FROM wp_mth_project WHERE mth_p_id = '".$_GET['project']."'"), ARRAY_A);
		if (strlen($project['mth_p_name']) > 60) {
			$breadcrumbs[] = substr(stripslashes($project['mth_p_name']), 0, 60)."...";
		} else {
			$breadcrumbs[] = stripslashes($project['mth_p_name']);
		}
	}
?>

<?php include (TEMPLATEPATH . "/header.php"); ?>
<div id="page-container">
<div id="page" class="width-limit">
<!--start left sidebar-->
<?php 
	if ($_GET['project']) {
?>
	<?php get_sidebar('left'); ?>
<!--end sidebar / start page content-->
    <div id="content" class="span-10">
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2 class="append-bottom prepend-top"><?= stripslashes($project['mth_p_name']) ?></h2>
			<div class="entry">	
	<h3 class="page_tagline"><?php echo ($project['mth_p_tagline']) ? stripslashes($project['mth_p_tagline']) : ""; ?></h3>
	
	<?php 
	// If there's a Project Page Image defined, echo it from the default directory (uploads)
	echo ($project['mth_p_banner']) ? "<img class=\"banner append-bottom\" src=\"".$url."/wp-content/uploads/".$project['mth_p_banner']."\" alt=\"".$project['mth_p_name']." Banner\" />\n\n" : "" ?>
	
	<p><?php echo stripslashes(nl2br($project['mth_p_desc_long'])); ?></p>
	
</div>
</div>
</div>
<!--end page content-->
<?php include (TEMPLATEPATH . "/sidebar-right.php"); ?>
<?
	} else {
?>
<!--****** start project category page ******-->
	<?php get_sidebar('left'); ?>
<!--end sidebar / start page content -->
    <div id="content" class="span-16 last">
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2 class="append-bottom prepend-top"><?php the_title(); ?></h2>
			<div class="entry">
	<h3 class="page_tagline">MITH's ongoing in-house, fellows, and community projects</h3>
	<ul class="projects">
	
	
	<?php
	$projects = $wpdb->get_results("SELECT * FROM wp_mth_project WHERE mth_p_status IN ('a','d') ORDER BY mth_p_name ASC", ARRAY_A);
    
	?>
			
	<?php
    foreach ($projects as $project) :
    ?>
    
    	<li>
    		<a name="<?php echo $project['mth_p_id']; ?>"></a>
				<a href="?project=<?php echo $project['mth_p_id']; ?>"><img src="<?php bloginfo('url') ?>/wp-content/uploads/<?= $project['mth_p_icon'] ?>" alt="<?= $project['mth_p_name']; ?>" /></a>
			<div class="project_description">
				<h4><a href="?project=<?php echo $project['mth_p_id']; ?>"><?php echo $project['mth_p_name']; ?></a></h4>
				<h5><?php echo $member['mth_p_tagline']; ?></h5>
				<p><?php echo stripslashes($project['mth_p_desc_short']); ?></p>
			</div>
			<div class="clear"></div>
		</li>
		
    <?php
    endforeach;
	?>
		
	</ul>
	<div class="clear"></div>
</div>
<!--end projects / start project archives -->	
		<h2 class="append-bottom prepend-top">Archived Projects</h2>
			<div class="entry" id="project-archives">
	<ul class="archivebox">
		<li>
			<ul>
		
			<?php
			$projects = $wpdb->get_results("SELECT * FROM wp_mth_project WHERE mth_p_status = 'r' ORDER BY mth_p_name ASC", ARRAY_A);
			foreach ($projects as $project) :
			?>
			
				<li>
					<a href="?project=<?php echo $project['mth_p_id']; ?>"><?php echo stripslashes($project['mth_p_name']); ?></a>
					 
				</li>
				
			<?php
			endforeach;
			?>
				<div class="clear"></div>
			</ul>
		</li>
		<li class="server">
			<h3 class="heading">MITH's Server Policy</h3>
			<p>We host MITH projects that are actively maintained by the project director in accordance with MITH's <a href="/research/serverpolicy">server policy</a>. A complete list of archived projects with contact information can be found below. If you notice a project that is missing, please contact us at <a href="mailto:mith@umd.edu">mith@umd.edu</a>.</p>
		</li>
		<div class="clear"></div>
	</ul>	
   </div>
<!--end project archives-->
  </div>
</div>
<!--end page content-->

<?php } ?>
</div>
<br clear="all" />
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>
