/**
 * Created by markus on 02.03.16.
 */




$(function() {
    $("time.timeago").timeago();
    //Dateigrößen umschreiben (Byte, KByte, MByte, etc)
    $(".filesize").filesize();

    function bootstrapAlert(msg) {
        return '<div class="alert alert-danger alert-dismissable">'+
            '<button type="button" class="close" ' +
            'data-dismiss="alert" aria-hidden="true">' +
            '&times;' +
            '</button>' +
            msg +
            '</div>'
    }



    $("#account-modal #save").click(function() {

        $.post("account/edit", $("#account-modal form").serialize()).success(function() {
            $("#account-modal").modal("hide");
            //The following is just for a better UX

            var formdata = $("#account-modal form").serializeArray();

            $.each(formdata, function(key, val) {
                var ref = $("#ihr-profil").find("#"+val.name);
                ref.text(val.value);
            });

            $.notify(
                {
                    message: "Daten erfolgreich übernommen!"
                },
                {
                    type: "success",
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    }
                });



        }).fail(function() {
            $("#account-modal").modal("hide");
            $.notify(
                {
                    message: "Bei der Verarbeitung der Eingabe ist ein Fehler aufgetreten!"
                },
                {
                    type: "danger",
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    }
                });
        })






    })



    $("#password-modal #save").click(function() {
        $("#password-modal").find(".has-error").removeClass("has-error");
        $("#password-modal #notifications").empty();


        var currentPassword = $("#password-modal form").find("input[name='currentPassword']").val();
        var newPassword = $("#password-modal form").find("input[name='newPassword']").val();
        var newPasswordRepeated = $("#password-modal form input[name='newPasswordRepeated']").val();


        if (currentPassword == "") {
            $("#password-modal form input[name='currentPassword']").parents(".form-group").addClass("has-error");
            $("#password-modal form #notifications").html(bootstrapAlert("Bitte geben sie ihr bisheriges Passwort ein!"));
            return;
        }

        if (newPassword == "") {
            $("#password-modal form input[name='newPassword']").parents(".form-group").addClass("has-error");
            $("#password-modal form #notifications").html(bootstrapAlert("Bitte geben sie eine neues Passwort ein!"));
            return;
        }


        if (newPassword != newPasswordRepeated) {
            $("#password-modal form input[name='newPasswordRepeated']").parents(".form-group").addClass("has-error");
            $("#password-modal form #notifications").html(bootstrapAlert("Neue Passwörter stimmen nicht überein!"));
            return;
        }

        $("#password-modal button").prop("disabled", true);
        $.post("account/changepw", $("#password-modal form").serialize()).success(function() {
            $("#password-modal button").prop("disabled", false);
            $("#password-modal").modal("hide");
            //The following is just for a better UX
            $.notify(
                {
                    message: "Passwort erfolgreich übernommen!"
                },
                {
                    offset: 60,
                    type: "success",
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    }
                });



        }).fail(function(data) {
            $("#password-modal button").prop("disabled", false);
            resp = $.parseJSON(data.responseText)


            if (resp.exception.type == "exceptions\\UnauthorizedException") {
                $("#password-modal form input[name='currentPassword']").parents(".form-group").addClass("has-error");
                $("#password-modal form #notifications").html(bootstrapAlert("Altes Passwort inkorrekt!"));
                return;
            }

            $("#password-modal form #notifications").html(bootstrapAlert("Es ist ein interner Fehler aufgetreten!"));


        })






    });


    $('#password-modal').on('hidden.bs.modal', function () {
        $("input[type=password]").val("");
    })




    function refreshNews() {

        $.getJSON( "news/getNews").done(function(data) {


            var html = "";
            $.each(data.data, function(key, val) {


                html+= '<li class="news-item"> ' +
                    '<strong>'+ val.user.vorname + ' ' + val.user.nachname +'</strong> ' +
                    '<time class="timeago" datetime="'+val.datetime+'"></time>' +
                    '<span data-id="'+val.id+'" class="click-cursor news-delete fa fa-times pull-right'+(val.user.id != data.currUser.id ?' display-none':'')+'"></span>' +
                    '<br>' +
                    val.content + '' +

                    '</li>';

            });
            $("#news-box").html(html);
            $("#news-box .timeago").timeago();

        })


    }



    $(".news-add").click(function() {

        bootbox.prompt({
            title: "Geben Sie eine Nachricht ein",
            value: "",
            callback: function(result) {
                if (result == "") {
                    alert("Darf nicht leer sein!");
                    return false;
                }

                if (result == null) return;

                $.post("news/post", { data : result }).success(function() {

                    refreshNews();



                });
            }
        });

    });


    $("#news-box").on("click", ".news-delete", function() {
        var id = $(this).attr("data-id");
        $.post("news/delete", { "id" : id }).success(function() {
            refreshNews();
        });

    });


    refreshNews();
    setInterval(refreshNews, 2000);




});




















$(function() {

    get_ajax_data();


    $( "#edit_autores" ).prop('disabled', true);

    function get_ajax_data () {
        var jqxhr = $.getJSON("EmailAccount/get", function(data) {})
            .fail(function() {
                $(".autores-status").text('Fehler!').removeClass("label-danger label-success").addClass("label-warning");
                //TODO: Does not work...
                $(".autores-edit").button("disable").prop("title", "Derzeit nicht möglich");

            })
            .always(function() {
            })
            .done(function(data) {
                if (data.data.aktiv == 1) {
                    $(".autores-status").text('Aktiv').removeClass("label-danger label-success").addClass("label-success");
                }
                else {
                    $(".autores-status").text('Inaktiv').removeClass("label-danger label-success").addClass("label-danger");
                }

                if (data.data.aktiv == 1) {
                    $( "#aktiv" ).prop("checked", true);
                } else {
                    $( "#aktiv" ).prop("checked", false);
                }

                if (data.data.autores_singlesend == 1) {
                    $( "#singlesend" ).prop("checked", true);
                } else {
                    $( "#singlesend" ).prop("checked", false);
                }

                $(".storage-bar").css("width", data.data.storage_percent+"%").text(data.data.storage_percent+"%");
                $( "#fromname" ).val(data.data.autores_fromname);
                $( "#subject" ).val(data.data.autores_subject);
                $( "#text" ).val(data.data.autores_text);
                $( "#full_name" ).text(data.data.user.vorname+ ' '+data.data.user.nachname);
                $( "#from" ).empty();
                for (var i = 0; i < data.data.user.mailAdressen.length; i++) {
                    if (data.data.from === data.data.user.mailAdressen[i]) {
                        $( "#from" ).append('<option selected value="'+data.data.user.mailAdressen[i]+'">'+data.data.user.mailAdressen[i]+'</option>');
                    } else {
                        $( "#from" ).append('<option value="'+data.data.user.mailAdressen[i]+'">'+data.data.user.mailAdressen[i]+'</option>');
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
        var jqxhr = $.post( "EmailAccount/post",$( "#autores-form" ).serialize(), function() {

        })
            .done(function() {
                get_ajax_data();
                if ($("#autores-form #aktiv").is(":checked")){
                    $.notify(
                        {
                            message: "Auto-Responder wurde aktiviert!"
                        },
                        {
                            type: "success",
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                } else {
                    $.notify(
                        {
                            message: "Auto-Responder wurde abgeschaltet."
                        },
                        {
                            type: "warning",
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                }
            })
            .fail(function() {
                alert( "error" );
            })
            .always(function() {

            });


    }



});
