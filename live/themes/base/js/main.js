$(document).ready(function() {

    var path = window.location.pathname;
    
    if ((path.indexOf('fonts') > -1) || (path.indexOf('rate') > -1)) {
        if ($('#stylewrap').length > 0) {
            $('#clicktosee').click(function() {
                $('#stylewrap').fadeIn();
				$('#styling').show();
            });
            
            // if ($('#stylewrap').css('display', 'block')) {
                $('#stylewrap').click(function() {
					$('#styling').hide();
                    $('#stylewrap').fadeOut();
                });
            // }
        }
    }
    
    /* note to self: 
       http://stackoverflow.com/questions/12572569/fade-transition-when-using-php-includes
     */

});