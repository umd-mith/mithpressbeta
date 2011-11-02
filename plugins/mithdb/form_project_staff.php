<script type="text/javascript">

jQuery(document).ready(function($){
	$('.drop').sortable({
		//dropOnEmpty: true,
		items: '.move',
		cursor: 'move',
		connectWith: ['.drop']
	});
	$('#clone .move').draggable({
		helper: 'clone',
		connectToSortable: '.drop'
	});
}); 

</script>



<div id="staff_list">
	<ul id="clone">
		<li class="move" id="s_1">Greg</li>
		
<?php
    $members = $wpdb->get_results("SELECT * FROM wp_mth_staff ORDER BY mth_s_last ASC", ARRAY_A);
    
    foreach ($members as $member) {
?>
	
		<li class="move" id="s_<?= $member['mth_s_id'] ?>">
			<?= $member['mth_s_last'].", ".$member['mth_s_first'] ?>
		</li>

<?php    
    }
?>			
		
	</ul>
</div>


<div id="staff_project">
	<ul id="project_list">
	
<?php
    $projects = $wpdb->get_results("SELECT mth_p_id,mth_p_name FROM wp_mth_project ORDER BY mth_p_name ASC LIMIT 5", ARRAY_A);
    
    foreach ($projects as $project) {
?>
	
		<li class="drop" id="p_<?= $project['mth_p_id'] ?>">
			<p><?= $project['mth_p_name'] ?></p>
		</li>

<?php    
    }
?>
		<li class="drop" id="trash">
			<p>(Drag removals here to discard.)</p>
		</li>

	</ul>
	
</div>

<input type="button" value="Test Output" onclick="testOutput()" />

<script type="text/javascript">

var projectList = document.getElementById('project_list');
function testOutput() {
	
	var p_s = new Array();


//	p_s[0][0] = 19
//	p_s[0][1] = 102,123

	var key = 0;

	for( var x = 0; x < projectList.childNodes.length; x++ ) {
		for ( var y = 0; y < projectList.childNodes[x].childNodes.length; y++) {
			if( projectList.childNodes[x].childNodes[y].nodeName.toLowerCase() == 'li' ) {
				
				var p_id = projectList.childNodes[x].attributes.id.nodeValue;
				window.alert( 'Project '+p_id+' includes: ' + projectList.childNodes[x].childNodes[y].attributes.id.nodeValue );
					
			}
		}
	}
}

</script>