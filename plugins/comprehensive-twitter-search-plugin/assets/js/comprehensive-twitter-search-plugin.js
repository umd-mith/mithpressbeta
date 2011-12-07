jQuery(document).ready(function ($) {

    if (!jQuery('input.twitter-search-color-picker').hasClass('miniColors')) {
        jQuery('input.twitter-search-color-picker').miniColors();
        jQuery('.miniColors-trigger').css("float", "right");
    }

    jQuery('.color-wrap .miniColors-trigger').css("float", "none");

});

jQuery(document).ajaxSuccess(

function (e, x, o) {

    jQuery(document).ready(

    function ($) {

		if (o.data != null) {
	
		var indexOftwitterSearch = o.data.indexOf('id_base=comprehensivetwittersearch');
        if (indexOftwitterSearch > 0)
        {
			var data = o.data;
 			data = data.split('&');
			var id = 0;

			jQuery.each(data, function() {
        
				var indexOfwidgetId = this.indexOf('widget-id');
		
		 		if (indexOfwidgetId == 0) {
					widget_id_arr = this.split('=');
					id = widget_id_arr[1];
					return id;
		 		}
   			});
			
            var cont_id = '#twitter-search-color-picker-container-' + id; 
		 	jQuery(cont_id + ' .miniColors-trigger').remove();
			if (!jQuery(cont_id + 'input.twitter-search-color-picker').hasClass('miniColors')) {
        		jQuery(cont_id + ' input.twitter-search-color-picker').miniColors();
        		jQuery(cont_id + ' .miniColors-trigger').css("float", "right");
    		}
        }
		}
    });
});
