/************************************************************
 ** Clears a field
 ** By: 	Joshua Sowin (fireandknowledge.org)
 ** HTML: <input type="text" value="Search" name="search"
 **			id="search" size="25" 
 ** 		onFocus="clearInput('search', 'Search')" 
 ** 		onBlur="clearInput('search', 'Search')" />
 ***********************************************************/
function clearInput(field_id, term_to_clear) {
	
	// Clear input if it matches default value
	if (document.getElementById(field_id).value == term_to_clear ) {
		document.getElementById(field_id).value = '';
	}
	
	// If the value is blank, then put back term
	else if (document.getElementById(field_id).value == '' ) {
		document.getElementById(field_id).value = term_to_clear;
	}
} // end clearInput()

$(function(){
    $('#project-info a img').hover(
    function() {
         $(this).stop().fadeTo('fast', 0.8);
    },
    function(){
        $(this).stop().fadeTo('fast', 1);
    }
  );
});

$(function(){
    $('#person a img').hover(
    function() {
         $(this).stop().fadeTo('fast', 0.8);
    },
    function(){
        $(this).stop().fadeTo('fast', 1);
    }
  );
});