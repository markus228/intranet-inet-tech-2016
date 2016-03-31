/**
 * Created by markus on 31.01.16.
 */
$(function() {




    var table = $('#example').DataTable( {
        "ajax": "staffSearch/allUsers",
        "columns": [
            { "data": "name" }
        ],
        paging: false,
        scrollY:        '55vh',
        scrollCollapse: true,
        searching: true,
        //Sortierung beibehalten
        ordering: true,
        //Infoleiste im unteren Bereich entfernen
        info: false,
        dom: "t",
        select: {
            style: "single"
        },
        fnDrawCallback: function(oSettings) {
            //Tabellenkopf ausblenden
            $(oSettings.nTHead).hide();
        },

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            /*console.log(nRow);
            console.log(aData);
            console.log(iDisplayIndex);
            console.log(iDisplayIndexFull);
            */

            $('td:eq(0)', nRow).attr('data-id', aData.id);


        }

    } );





    //Suchfeld aktivieren
    $(".staff-search").on( 'keyup', function () {
        table.search( this.value ).draw();

    });

    table.on( 'select', function ( e, dt, type, indexes ) {
        if ( type === 'row' ) {
            var out = table.rows(indexes).nodes().to$();
            var id = out.find("td:eq(0)").attr("data-id");

            console.log("id", id);

            /*
            console.log(e);
            console.log(dt);
            console.log(type);
            console.log(indexes);
            */
            var data = table.ajax.json().data;

            //console.log("data", data);


            var dataset = {};


            //Datensatz ermitteln
            $.each(data, function(key, val) {
                if (val.id == id) {
                    dataset = val;
                }
            });


            //Detail-View sichtbar machen
            $(".staff-details").show();

            //Werte zuweisen
            $.each(dataset, function(key, val) {


                //De facto ggw. nur MailAdressen
                if (val instanceof Array) {


                    $("span.staff-"+key).html(val.join("<br>"));

                    //Mail Links
                    if(key == "mailAdressen") {
                        $("span.staff-mailAdressenLinks").empty();
                        $.each(val, function(key, val) {
                            $("span.staff-mailAdressenLinks").append('' +
                                (key > 0?'<br>':'')+'<a href="mailto:'+val+'"><span class="fa fa-envelope-o fa-large-icon"></span></a>'
                            );
                        });
                    }
                //Alles andere
                } else {

                    $("span.staff-" + key).text(val);

                }

                //Telefon-Links generieren
                $("a.staff-"+key+".telephone").attr("href", "tel:"+val);

            });

            //Google Maps Link einfügen...
            $(".staff-map").attr("href", 'https://maps.google.com/?q='+encodeURI(dataset.strasse+" "+dataset.hausnr+" "+dataset.plz+" "+dataset.ort)).attr("target", "__blank");


            //Mobile Devices

            if (!$("#detail-view").is(":visible")) {

                $("#modal-fullscreen .modal-body").html(
                    $("#detail-view .panel-body").html()
                );
                $("#modal-fullscreen").modal("show");



            }


        }
    } );

});