jQuery(document).ready(function() {
	
	// jQuery('#add_tab').click( function( e ) {
	// 	e.preventDefault();
	// 	var admin_ajax =jQuery('#admin_ajax').val();
	// 	var number_of_tabs =jQuery('#number_of_tabs').val();
	// 	ajaxurl = admin_ajax;
	// 	    jQuery.post(
	// 	      ajaxurl, 
	// 	      {
	// 	        'action': 'addtab',
	// 	        'number_of_tabs':  number_of_tabs,
	// 	      }, 
	// 	      function(response){
	// 	      	alert(response);
	// 	      	jQuery( "#cn_options_group" ).append(response);
	// 	      }
	// 	    );
	// });

	jQuery('.cn_delete_tabs').click( function( e ) {
		var number_of_tabs=jQuery('#number_of_tabs').val();
		jQuery('#number_of_tabs').val(number_of_tabs-1);
		jQuery(this).parent().remove();
		jQuery( "#publish" ).trigger( "click" );
	});

	jQuery('#add_pricing').click( function( e ) {
		e.preventDefault();
		jQuery( "#publish" ).trigger( "click" );
	});

	
	

});
