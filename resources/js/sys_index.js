$(function() {
    reloadAccounts();
    
function reloadAccounts() {
    var items = [];  
    $("#accounts").html('<img src="./img/ajax-loader.gif">'); 
    var jqxhr = $.getJSON( "sys_get_all_accs.php", function(data) {
    })
    .done(function(data) {
        $("#accounts").html('<h3>Alle registrierten und verknuepften Konten</h3><ul></ul>');  
        for (var i = 0; i < data.accs.length; i++) {
           items.push("<li>"+data.accs[i].ldap_login+" - "+data.accs[i].email+"</li>");
       }
       $("#accounts ul").append( items.join('') );
    
    })
    .fail(function(data) {
    $("#result_reload_all").text('Es ist ein Fehler aufgetreten: '+ data.responseText);
    });
    
    
}

$( "#reload_all" ).button().click(function() {
   var items = [];   
   $("#result_reload_all").html('<img src="./img/ajax-loader.gif">');
   var jqxhr = $.getJSON("sys_reload_all.php", function(data) {})
   .fail(function(data) {
    $("#result_reload_all").text('Es ist ein Fehler aufgetreten: '+ data.responseText);
      })
    .done(function(data) {
       $("#result_reload_all").html("<h3>Vorgang abgeschlossen</h3><p>KIS Import abgeschlossen "+ data.count +" Datensaetze (Accounts).</p><p>LDAP-Verknuepfung abgeschlossen</p><p>Kennungen die nicht zugeordnet werden konnten:</p><ul></ul>");
       for (var i = 0; i < data.nomatch.length; i++) {
           items.push("<li>"+data.nomatch[i].kennung+" - "+data.nomatch[i].cn+"</li>");
       }
       $("#result_reload_all ul").append( items.join('') );
       reloadAccounts();
   } );  

});

$( "#reload_kis" ).button().click(function() {
   $("#result_reload_kis").html('<img src="./img/ajax-loader.gif">');   
   var jqxhr = $.getJSON( "sys_reload_kis.php", function(data) {
    })
    .done(function(data) {
        $("#result_reload_kis").html('<h3>Vorgang abgeschlossen</h3><p>KIS Import abgeschlossen '+ data.count +' Datensaetze (Accounts)</p>');
    })
    .fail(function(data) {
    $("#result_reload_all").text('Es ist ein Fehler aufgetreten: '+ data.responseText);
    });

});
$( "#reload_ldap_map" ).button().click(function() {
   $("#result_reload_ldap_map").html('<img src="./img/ajax-loader.gif">');
   var items = [];
   var jqxhr = $.getJSON("sys_reload_ldap_map.php", function(data) {})
   .fail(function(data) {
    $("#result_reload_ldap_map").text('Es ist ein Fehler aufgetreten: '+ data.responseText);
      })
   .done(function(data) {
       $("#result_reload_ldap_map").html("<h3>Vorgang abgeschlossen</h3><p>Kennungen die nicht zugeordnet werden konnten:</p><ul></ul>");
       for (var i = 0; i < data.nomatch.length; i++) {
           items.push("<li>"+data.nomatch[i].kennung+" - "+data.nomatch[i].cn+"</li>");
       }
       $("#result_reload_ldap_map ul").append( items.join('') );
       reloadAccounts();
   } );  
        
});
});