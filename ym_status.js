jQuery(document).ready(function($){
    var num_user = $('#[id$="num_user"]').val();
    response = '';
    $('#[id$="num_user"]').change(function(){
        
          //  num_user = $(this).val();
           // populate_input(num_user);
          //  $('#[id$="num_user"]').replaceWith(response['num_user']);
            //$('#yahoo_users').replaceWith(response['yahoo_users']);
        
    });
});

function populate_input(num_user) {
    jQuery.ajax({ 
        type: "get",					
        url: ajaxurl,			
        data: {
            //this action is needed by wordpress for identification and response
            action: 'ym_status',
            num_user: num_user	
        },
        success: function(responseText){
            response = responseText;			
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("error");
        }
    });
}