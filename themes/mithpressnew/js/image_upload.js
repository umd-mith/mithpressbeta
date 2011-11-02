// JQuery Uploads Script

jQuery(document).ready(function() {
 
jQuery('#upload_image_button').click(function() {
											  window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#upload_image').val(imgurl);
 tb_remove();
 
 
}
 
 
 tb_show('', 'media-upload.php?post_id=1&amp;type=image&amp;TB_iframe=true');
 return false;
});
 
 
});
 
jQuery(document).ready(function() {
 
jQuery('#upload_image_button2').click(function() {
											   window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#upload_image2').val(imgurl);
 tb_remove();
 
 
}
 
 tb_show('', 'media-upload.php?post_id=1&amp;type=image&amp;TB_iframe=true');
 return false;
});
 
 
 
});