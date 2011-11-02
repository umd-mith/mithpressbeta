<link href="meta.css" rel="stylesheet" type="text/css" />
<div class="project_details_panel">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras orci lorem, bibendum in pharetra ac, luctus ut mauris. Phasellus dapibus elit et justo malesuada eget <code>functions.php</code>.</p>
  <div class="project_details_column left">

	<label>Project Website</label>
	<p>
		<span>URL</span>
        <input type="text" name="_my_meta[link]" value="<?php if(!empty($meta['link'])) echo $meta['link']; ?>"/>
	</p>
	<label>Contact</label>
	<p>
        <span>Name</span>
		<input type="text" name="_my_meta[contactname]" value="<?php if(!empty($meta['contactname'])) echo $meta['contactname']; ?>"/>
    </p>
    <p>
        <span>Email</span>
		<input type="text" name="_my_meta[contactemail]" value="<?php if(!empty($meta['contactemail'])) echo $meta['contactemail']; ?>"/>
	</p>
  </div>
  <div class="project_details_column right">
	<label>Project Image</label>
  	<p>
		<span>Url or Upload</span>
        <input type="text" name="_my_meta[projectimage]" value="<?php if(!empty($meta['projectimage'])) echo $meta['projectimage']; ?>"/>
        <input type="button" name="upload_image_button" id="upload_image_button" value="Browse" class="upload_button" />
  	</p>
  </div>
</div>