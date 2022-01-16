(function( $ ) {
	'use strict';

	
	$(function() {
		$( '.dft-display-days' ).on( 'click', function(){
			var p_id = $( this ).attr( 'data-pid' );
			
			var data = {
			    action: 'get_dt_desc',
			    p_id: p_id
			};
			
			if( $( '.dft-display-time-desc' ).is( ':empty' ) ) {
			    
			    $.ajax({
		            type:       'POST',
		            url:        front_ajax_object.ajaxurl,
		            dataType:   "json",
		            data: data,
		            success:    function( success ) {
		                if( success.success == 'yes' ) {
		                	$( '.dft-display-time-desc' ).text( success.desc );
		                	$( this ).trigger( 'click' );
		                }
		            },
		            error: function() {
		                
		            },
		            
		        });
		    }
			else {
			    $( '.dft-display-time-desc' ).toggle( 'slow' );
			}

	        return false;
		} )
	});
	

})( jQuery );
