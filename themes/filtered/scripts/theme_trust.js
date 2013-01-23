jQuery.noConflict();
jQuery(document).ready(function(){
	
	jQuery(".gallery a").attr('rel', 'gallery').fancybox({
			'overlayColor'	:	'#000',
			'titleShow'	:	false,
			'titlePosition'	:	'inside'
	});
	
	jQuery("a.lightbox").fancybox({
			'overlayColor'	:	'#000',
			'titleShow'	:	false,
			'titlePosition'	:	'inside'
	});	

});