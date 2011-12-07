<div class="my_meta_control">
<p style="padding-top:10px; float:left;">
     <a href="#" class="docopy-slider' button">Add New Slide</a>
</p>
<a style="float:right; margin:10px 10px;"
     href="#" class="dodelete-slider' button">
     Remove All
</a>
<div style="Clear:both"></div>
    <?php while($mb->have_fields_and_multi('slider')): ?>
        <?php $mb->the_group_open(); ?>
     <?php $mb->the_field('header'); ?>
	  <label>Title</label>
	  <p>
             <input type="text" name="<?php $mb->the_name(); ?>"
             value="<?php $mb->the_value(); ?>"/>
           </p>

	  <?php $mb->the_field('content'); ?>
          <label>Content</label>
               <textarea style="min-height:400px" name="<?php $mb->the_name(); ?>">
               <?php $mb->the_value(); ?></textarea>

         <a href="#">Remove</a>
          <br/><br/>
      <?php $mb->the_group_close(); ?>
  <?php endwhile; ?>

</div>