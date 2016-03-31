$(function() {

    get_ajax_data();


    $( "#edit_autores" ).prop('disabled', true);

function get_ajax_data () {
        var jqxhr = $.getJSON("intern_ajax_autoresponder_get.php", function(data) {})
        .fail(function() {
            $("#autores_status").text('Status derzeit nicht verfügbar.');
            $("#autores_status").css("color", "red");
            $( "#edit_autores" ).button( "disable" );
            $( "#edit_autores" ).prop("title", "Derzeit nicht möglich");
            
        })
        .always(function() {
        })
        .done(function(data) {
           if (data.aktiv === 1) {
                $("#autores_status").text('aktiv');
                $("#autores_status").css("color", "green");
            }
            else {
            $("#autores_status").text('inaktiv');
            $("#autores_status").css("color", "red");
            }
            
            if (data.aktiv === 1) {
                $( "#aktiv" ).prop("checked", true); 
            } else {
                $( "#aktiv" ).prop("checked", false);
            }
            
           if (data.singlesend === 1) {
                $( "#singlesend" ).prop("checked", true); 
            } else {
                $( "#singlesend" ).prop("checked", false);
            }
            
            $( "#fromname" ).val(data.fromname);
            $( "#subject" ).val(data.subject);
            $( "#text" ).val(data.text);
            $( "#full_name" ).text(data.full_name);
            $( "#from" ).empty();
            for (var i = 0; i < data.availableaddr.length; i++) {
            if (data.from === data.availableaddr[i]) {
               $( "#from" ).append('<option selected value="'+data.availableaddr[i]+'">'+data.availableaddr[i]+'</option>'); 
            } else {
            $( "#from" ).append('<option value="'+data.availableaddr[i]+'">'+data.availableaddr[i]+'</option>');
                //Do something
            
            }    
            }
                $( "#edit_autores" ).prop('disabled', false);
        });

}


$("#save").click(function() {
    $( "#edit_autores" ).prop('disabled', true);
    $('#myModal').modal('hide');
    postData();
    
});

function postData() {
    $( "#edit_autores" ).button( "disable" );
    $( "#autores_status" ).html('<span id="autores_status"><img src="./img/ajax-loader.gif"></span>');    
    var jqxhr = $.post( "intern_ajax_autoresponder_post.php",$( "#autores-form" ).serialize(), function() {
        
    })
    .done(function() {
            get_ajax_data();
    })
    .fail(function() {
        alert( "error" );
     })
    .always(function() {

    });
    
    
}



   }); 
    