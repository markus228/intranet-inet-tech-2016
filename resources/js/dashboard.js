/**
 * Created by markus on 26.12.15.
 */
$(function() {



    /*
    Automatische Ermittlung der aktuellen Seite...
     */


    var url = window.location;
    var element = $('ul.nav a').filter(function() {


        console.log(this.href, url)

        return this.href == url;
    }).addClass('active').parent().addClass("active").parent().addClass('in');





});