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

<?php 
	if ($_GET['project']) {
?>
<!--Start Individual Project Page-->		
<div class="main">
	<h2><?= stripslashes($project['mth_p_name']) ?></h2>
	<h3 class="page_tagline"><?php echo ($project['mth_p_tagline']) ? stripslashes($project['mth_p_tagline']) : ""; ?></h3>
	
	<?php 
	// If there's a Project Page Image defined, echo it from the default directory (uploads)
	echo ($project['mth_p_banner']) ? "<img class=\"banner\" src=\"".$url."/wp-content/uploads/".$project['mth_p_banner']."\" alt=\"".$project['mth_p_name']." Banner\" />\n\n" : "" ?>
	
	<p><?php echo stripslashes(nl2br($project['mth_p_desc_long'])); ?></p>
	
</div>
<div id="sidebar">
	<ul>
		<li>
			<?php if ($project['mth_p_url']) { ?>
				<h2>View the live site</h2>
				<p>Please follow the link below to see the live website associated with this project.</p>
				<p><a class="sidebar_button" href="<?php echo $project['mth_p_url'] ?>">View Project &raquo;</a></p>
				<p class="clear"></p>
			<?php } else { ?>
				<?php if ($project['mth_p_status'] == 'd') : ?>
					<h2>In development</h2>
					<p>This project is currently in development. More information will be posted here as it becomes available.</p>
				<?php elseif ($project['mth_p_status'] == 'r') : ?>
					<h2>Archived Project</h2>
					<p>This project is retained in MITH's archives, but is not presently being served online.</p>
					<!--<br />
					<p>For more information about this project, please <a href="<?php bloginfo('url'); ?>/about/contact/">Contact MITH</a>.</p>-->
				<?php endif; ?>
			<?php } ?>
		</li>
	</ul>

	<?php if ($project['mth_p_email']) : ?>
	<ul>
		<li>
			<h2>Contact Information</h2>
			<p>For questions or more information about this project, please contact:</p>
			<br />
			<p class="project_contact"><strong><?php echo $project['mth_p_contact']; ?></strong><br />
			<?php echo $project['mth_p_email']; ?></p>
		</li>
	</ul>
	<?php endif; ?>
	
	
	<?php if ($project['mth_p_stafflist']): ?>
	
	<ul>
		<li>
			<h2>Participating MITH Staff</h2>
			<ul>
			<?php
				
					if ($project['mth_p_stafflist']) {
					
						$stafflist = array();
						$staff1 = explode("&",$project['mth_p_stafflist']);
						foreach ($staff1 as $staff) {
							$staff2 = explode("=",$staff);
							$stafflist[] = $staff2[1];
						}
						$stafflist = implode(",",$stafflist);
						//print_r($stafflist);
						$members = $wpdb->get_results( $wpdb->prepare("SELECT mth_s_id,mth_s_last,mth_s_first,mth_s_title FROM wp_mth_staff WHERE mth_s_id IN ($stafflist) ORDER BY FIELD(mth_s_id, $stafflist)" ), ARRAY_A);
						foreach ($members as $member) :
						
						?>
							
				<li>
					<a href="<?php bloginfo('url'); ?>/mithstaff/#<?php echo strtolower($member['mth_s_first'].$member['mth_s_last']); ?>" style="float: left"><?php echo $member['mth_s_first']." ".$member['mth_s_middle']." ".$member['mth_s_last']; ?></a>
					<small class="staff_title"><?php echo $member['mth_s_title']; ?></small>
					<div class="clear"></div>
				</li>
							
					<?php
						
						endforeach;
					
					}
				
					?>
			</ul>
		</li>
	</ul>
	<?php endif; ?>
	
	<?php if (($project['mth_p_start'] > 1) || ($project['mth_p_end'] > 1) || ($project['mth_p_launch'] > 1) || $project['mth_p_platform'] || $project['mth_p_license']): ?>	
	
	<ul>
		<li><h2>Project Details</h2>
			
			<?php 
			if (($project['mth_p_start'] > 1)
			|| ($project['mth_p_end'] > 1) 
			|| ($project['mth_p_launch'] > 1)): 
			?>
			<ul>
				<li>
					<h4>Dates</h4>
					<?php echo ($project['mth_p_start']) ? "<p>Started in ".date("M Y", strtotime($project['mth_p_start']))."</p>\n" : "" ?>
					<?php if ($project['mth_p_end'] > 1) echo ($project['mth_p_end']) ? "<p>Ended in ".date("M Y", strtotime($project['mth_p_end']))."</p>\n" : "" ?>
					<?php if ($project['mth_p_launch'] > 1) echo ($project['mth_p_launch']) ? "<p>Launched in ".date("M Y", strtotime($project['mth_p_launch']))."</p>\n" : "" ?> 
				</li>
			
			</ul>
			<?php endif; ?>
			
			<?php if ($project['mth_p_platform']): ?>
			<ul>
				<li>
					<h4>Platform</h4>
					<p><?php echo $project['mth_p_platform'] ?></p>
				</li>
			
			</ul>
			<?php endif; ?>
			
			<?php if ($project['mth_p_license']): ?>
			<ul>
				<li>
					<h4>License</h4>
					<p><?php echo $project['mth_p_license'] ?></p>
				</li>
			
			</ul>
			<?php endif; ?>
			
		</li>
	</ul>
	<?php endif; ?>
	
	<?php if ($project['mth_p_related']): ?>
	<ul>
		<li><h2>Related Projects</h2>
		<ul>
		
<?php
	$relatedlist = array();
	$related1 = explode("&",$project['mth_p_related']);
	foreach ($related1 as $related) {
		$related2 = explode("=",$related);
		$relatedlist[] = $related2[1];
	}
	$relatedlist = implode(",",$relatedlist);
	//print_r($stafflist);
	$relateds = $wpdb->get_results( $wpdb->prepare("SELECT mth_p_id,mth_p_name FROM wp_mth_project WHERE mth_p_id IN ($relatedlist) ORDER BY FIELD(mth_p_id, $relatedlist)" ), ARRAY_A);
	foreach ($relateds as $related): 
?>

			<li>
				<a href="?project=<?= $related['mth_p_id'] ?>"><?= $related['mth_p_name'] ?></a>
			</li>
		
<?php
	endforeach;		
?>

		</ul>
	
	
	<?php endif; ?>
	
</div>
<div class="clear"></div>
		
		<?
		
	} else {
?>
<!--Start Project Category Page-->
<div class="main full">
	<h2>Our Work</h2>
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
	
	
	<ul class="archivebox">
		<li>
			<h3 class="heading">Archived Projects</h3>
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
<!-- <div id="sidebar">
	<ul>
		<li>
			<h2>Active Projects</h2>
			<ul>
		
			<?php
			$projects = $wpdb->get_results("SELECT * FROM wp_mth_project WHERE mth_p_status = 'a' ORDER BY mth_p_name ASC", ARRAY_A);
			foreach ($projects as $project) :
			?>
			
				<li>
					<a href="#<?php echo $project['mth_p_id']; ?>"><?php echo stripslashes($project['mth_p_name']); ?></a>
					<div class="clear"></div>
				</li>
				
			<?php
			endforeach;
			?>
				
			</ul>
		</li>
	</ul>
	<ul>
		<li><h2>About Our Work</h2></li>
		<li><p>MITH's work lies at the nexus of technology and the humanities.</p></li>
		<li>
			<ul>
				<li><a href="#">Events</a></li>
				<li><a href="#">Software &amp; Tools</a></li>
				<li><a href="#">Research</a></li>
			</ul>
		</li>
	</ul>
	<ul> 
		<li>
			<h2>MITH's Server Policy</h2>
			<p>We host MITH projects that are actively maintained by the project director in accordance with MITH's <a href="/research/serverpolicy">server policy</a>. A complete list of archived projects with contact information can be found below. If you notice a project that is missing, please contact us at <a href="mailto:mith@umd.edu">mith@umd.edu</a>.</p>
		</li>
	</ul>
	
	<div class="clear"></div>
</div> -->


<?php } ?>

<?php get_footer(); ?>
