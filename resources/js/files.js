

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "filenm-pre": function ( a ) {
        $(a)
        if (a == null || a == "") {
            return 0;
        }
        var ukDatea = a.split('/');
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },

    "filenm-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "filenm-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );


$(function() {

    //URL auslesen
    var req = $(location).attr("href");

    var upload;


    //Page Header für Balken anpassen
    $(".page-header").append('<div id="mprogress" style="height: 3px; margin-top: 16px"></div>');
    $(".page-header").css("padding-bottom", 0);

    //Fortschrittsbalken installieren
    var mprogress = new Mprogress({
       template: 1,
        parent: "#mprogress"
    });




    //Verhindert das der DrawCallback aufgerufen wird wenn keine neue Daten vorliegen
    //TODO: Evtl. die Variable direkt ins Plugin stricken...
    var tableAjaxJSInitialized = false;

    //Tabelle intialisieren
    var table = $("table").DataTable(
        {
            //Ajax Datenquelle
            //ajax: "files/goAjax",

            ajax: {
                url: "files/goAjax",
                dataSrc: function(d){

                    //TODO: Nur wenn tatsächlich Änderungen aufgetreten sind!
                    tableAjaxJSInitialized = false;
                    return d.data;
                }
            },
            //Kein Paging
            paging: false,
            columnDefs:[
                {
                    targets: 0
                    //type: "filenm"
                }

            ],
            select: {
                style: "os",
                //Zuruekc Ordner soll nicht auswählbar sein!
                selector: ":has(td:has([data-path!=''][data-path]))"
            },

            responsive: {
                details: {
                    //Modal mit Zusatzinfos wenn Display zu klein
                    display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            var data = row.data();
                            console.log(data);
                            return 'Infos zu '+data[0];
                        }
                    } )
                }
            },
            "fnInitComplete": function() {
                console.log("fnInitComplete");
                /*
                 Wird einmalig beim Laden der Seite ausgelöst
                 */



                //Zusätzlichen HTML-Code in Tabelle einfügen
                var html =
                    '<div class="row">' +
                        '<div class="col-sm-12">' +
                            '<ol class="breadcrumb">' +
                                '<li><a class="files-link-res file-folder" data-ajax-href="files/goAjax"><span class="fa fa-home"></span></a></li>' +
                            '</ol>' +
                        '</div>' +
                    '</div>' +
                    '<div class="row">' +
                        '<div class="col-sm-12">' +
                            '<div class="btn-group">'+
                                '<span class="btn btn-default fileinput-button"> ' +
                                    '<i class="fa fa-upload"></i> ' +
                                    '<span>Upload</span> ' +
                                    '<input id="fileupload" type="file" name="files[]" multiple> ' +
                                '</span>'+
                                    '<div class="btn-group">'+
                                        '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                                            'Neu <span class="caret"></span>'+
                                        '</button>'+
                                        '<ul class="dropdown-menu">'+
                                            '<li><a class="create-txt-file" href="javascript:void(0); "><span class="fa fa-file-o"></span> Text-Datei</a></li>'+
                                            '<li><a class="create-folder" href="javascript:void(0);"><span class="fa fa-folder-o"></span> Ordner</a></li>'+
                                        '</ul>'+
                                    '</div>' +
                            '</div>'+
                            '<button class="btn btn-default pull-right delete-object"><span class="fa fa-trash"></span> Löschen</button>'+
                        '</div>' +

                        //'<div class="col-sm-4"> <button class="btn btn-default">Neuer Ordner</button></div>' +

                        '<div class="col-sm-8">' +
                            //'<div id="upload-status">' +
                            '' +
                            //'<div id="progress" style="text-align: center" class="progress"> ' +
                            //'<div class="progress-bar progress-bar-success">' +
                            //'</div> ' +
                            //'</div>' +
                            //'</div>' +
                        '</div>' +



                    '</div>';

                var out = $("#files div.dataTables_wrapper div.row div.col-sm-6").first();
                out.html(html);



                $(".create-folder").click(function() {
                    bootbox.prompt({
                        init: function() {

                        },
                        locale: "de",
                        title: "Name für den neuen Ordner",
                        value: "Neuer Ordner",
                        callback: function(result) {
                            $.ajax({
                                url: "files/createFolder/" + $("#files").attr("data-current-path"),
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    "folderName": result
                                },
                                success: function (data) {
                                    table.ajax.reload(null, false);
                                }

                            });
                        }

                    });
                    return true;
                });



                $(".delete-object").click(function() {
                    var data = table.rows('.selected').nodes().to$();
                    var num_selected = 0;
                    var del_paths = [];
                    data.each(function (i) {
                        var path = $(this).find("[data-path]").attr("data-path");
                        if (path != "") {
                            num_selected++;
                            del_paths.push(path);
                        }
                    });

                    if (num_selected < 1) {
                        alert("Nichts ausgewählt");
                        return;
                    }


                    bootbox.confirm("Sind Sie sicher, dass sie <b>"+num_selected+" Objekte</b> löschen wollen?", function(res) {
                        if (!res) return;
                        $.ajax({
                            url: "files/deleteObjects",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                "objects": del_paths
                            },
                            success: function (data) {
                                table.ajax.reload(null, false);
                            }

                        });

                    });
                });



                $(".create-txt-file").click(function() {
                    bootbox.prompt({
                        init: function() {

                        },
                        locale: "de",
                        title: "Name für die neue Datei",
                        value: "datei.txt",
                        callback: function(result) {
                            $.ajax({
                                url: "files/createFile/" + $("#files").attr("data-current-path"),
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    "fileName": result
                                },
                                success: function (data) {
                                    table.ajax.reload(null, false);
                                }

                            });
                        }

                    });
                    return true;
                });

                //Suche modifizieren
                var searchLabel= $("#files div.dataTables_wrapper div.row div.dataTables_filter label");

                searchLabel.contents().filter(function(){
                    return (this.nodeType == 3);
                }).remove();

                searchLabel.parent().css("margin-top", "5px");

                //Placeholder für Suche einfügen
                var input = searchLabel.find("input");
                input.attr("placeholder", "Suche...");
                input.attr("size", 30);


                //FileUpload einbauen
                $("#fileupload").fileupload({
                    //Aktuellen Pfad mitgeben
                    url: "files/upload/",
                    dataType: 'json',
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            table.ajax.reload( null, false );
                            console.log(file.name);
                            $.notify(
                                {
                                    message: file.name +" wurde hochgeladen!"
                                },
                                {
                                    type: "success",
                                    animate: {
                                        enter: 'animated fadeInDown',
                                        exit: 'animated fadeOutUp'
                                    }
                                });
                            //$('#progress .progress-bar').text(file.name)
                        });
                    },
                    //Callback für Progressbar
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        mprogress.set(progress/100);
                        /*$('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                        $('#progress .progress-bar').text(progress+'%');*/

                    },
                    fail: function(e, data) {
                        alert("failed!");
                    }

                })

                    //Anscheinend Drap&Drop Zeugs
                    .prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');


            },
            //Wenn Tabelle aufgebaut wird...
            "fnDrawCallback":function(){
                if (tableAjaxJSInitialized) return;
                if (table == undefined) return;


                console.log("fnDrawCallback");

                //Dateigrößen umschreiben (Byte, KByte, MByte, etc)
                $(".filesize").filesize();
                //Zeiten umschreiben (Vor XYZ Tagen..)
                $("time.timeago").timeago();

                //Aktuellen Pfad setzen..
                //if (table != undefined) {
                $("#files").attr("data-current-path", table.ajax.json().path);
                //}


                //Breadcrumbs aktualisieren
                $(".breadcrumb").empty();
                var ajaxBreadcrumbs = table.ajax.json().splitpath;

                $(".breadcrumb").append('<li><a class="files-link-res file-folder" href="#" data-ajax-href="files/goAjax"><span class="fa fa-home"></span></a></li>');
                $.each(ajaxBreadcrumbs, function(key, value) {
                    $(".breadcrumb").append('<li><a class="files-link-res file-folder" href="#" data-ajax-href="'+key+'">'+value+'</a></li>');
                });


                //Links deaktivieren und auf dynmaisches Nachladen umstellen
                $("a.files-link-res.file-folder").click(function() {
                    var orig_href = this.href;
                    var ajax_href = $(this).attr("data-ajax-href");

                    table.ajax.url(ajax_href).load();
                    return false;
                });


                //Upload URL aktualisieren
                $("#fileupload").fileupload('option', {
                        'url': "files/upload/" + $("#files").attr("data-current-path")
                    }
                );


                tableAjaxJSInitialized = true;
            },
            "fnPreRowSelect" : function(e, nodes) {

                console.log(e);
                if (e.find("[data-path]").attr("data-path") == "") {
                    return false;
                }
            }
        }
    );


    table.on( 'select', function ( e, dt, type, indexes ) {
            var out = table.rows(indexes).nodes().to$();
            var id = out.find("td:eq(0) [data-path]");

        }
    );




    /*setInterval( function () {
        table.ajax.reload(null, false); // user paging is not reset on reload
    }, 30000 );*/






});