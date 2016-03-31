<?php
/**
 * @var \view\PersoenlicheStatusseiteView $this
 */
?>
<div class="row">

    <div id="ihr-profil" class="col-lg-4 col-md-5 col-sm-6">
    <div class="panel panel-default autoheight">
        <div class="panel-heading">Ihr Profil</div>
        <div class="panel-body">
            <div class="row">
            <div class="col-md-5 col-sm-6 col-xs-5">
                <div class="row">
                    <div class="col-md-12">
                        <img src="https://placehold.it/175x125" alt="" class="img-rounded img-responsive" />
                    </div>
                </div>
                <div class="row" style="margin-top: 25%">
                    <div class="col-md-12">
                        <div class="btn-group-vertical">

                            <button id="edit-account" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#account-modal" style="">
                                <span class="fa fa-edit"></span>
                                Bearbeiten
                            </button>
                            <button id="change-pw" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#password-modal" style="">
                                <span class="fa fa-lock"></span>
                                Passwort ändern
                            </button>


                        </div>


                    </div>
                </div>

            </div>
            <div id="ihr-profil" class="col-md-7 col-sm-6 col-xs-7">
                <h4 style="margin-top: 0;">
                    <span id="vorname"><?=$this->getUser()->getVorname()?></span> <span id="nachname"><?=$this->getUser()->getNachname()?></span><br>
                    <small><strong><span id="username"><?=$this->getUser()->getUsername()?></span></strong></small>
                </h4>


                <address>
                    <span id="strasse"><?=$this->getUser()->getStrasse()?></span> <span id="hausnr"><?=$this->getUser()->getHausnr()?></span> <br>
                    <span id="plz"><?=$this->getUser()->getPlz()?></span> <span id="ort"><?=$this->getUser()->getOrt()?></span>
                </address>

                <span class="fa fa-phone"></span> <?=$this->getUser()->getTelefonDurchwahl()?><br>
                <span class="fa fa-envelope"></span> <?=$this->getUser()->getMailAdressen()[0]?> <br>
                <abbr title="Letzte Anmeldung"><span class="fa fa-clock-o"></span></abbr> <time datetime="<?=$this->getUser()->getLastLoginISO8601()?>" class="timeago"><?=$this->getUser()->getLastLogin()?></time>

            </div>
        </div>
        </div>
    </div>
    </div>
    <div id="aktuelle-ereignisse" class="col-lg-8 col-md-7 col-sm-6">
        <div class="panel panel-default autoheight">
            <div class="panel-heading">Aktuelle Ereignisse<span class="click-cursor glyphicon glyphicon-plus pull-right news-add" aria-hidden="true"></span></div>
            <div class="panel-body" style="overflow-y: scroll;">
                <ul style="display: block" id="news-box">

                </ul>


            </div>

        </div>
    </div>

</div>





<div class="row">

    <div class="col-lg-4 col-md-5 col-sm-6">
        <div class="panel panel-default autoheight">
            <div class="panel-heading">EMail-Konto</div>
            <div class="panel-body" style="height:205px;">
                <!--<div class="row">
                    <div class="col-md-4">
                       <h4>Adressen</h4>
                    </div>
                    <div class="col-md-8">
                        <ul class="list-group" style="margin-bottom: 10px;">
                            <?
                            foreach($this->getUser()->getMailAdressen() as $email) {
                                echo '<li class="list-group-item list-group-item-small">'.$email.'</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>-->

                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <h4>Auto-Responder</h4>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <h4 class="text-right"><span class="autores-status label">...</span></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm autores-edit" data-toggle="modal" data-target="#myModal"> <span class="fa fa-edit"></span> Einstellungen</button>
                    </div>
                </div>

                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">
                        <h4>Genutzter Speicher</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="progress-bar storage-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                Lädt...
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-7 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Zuletzt verwendete Dateien</div>
            <!-- Table -->
            <div class="table-responsive" style="height: 205px;">
                <?=$this->getRecentlyChangedFilesView()?>
            </div>


        </div>

    </div>
</div>





<div id="modal-container">



    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Auto-Responder: <span id="full_name"></span></h4>
                </div>
                <div class="modal-body">
                    <div id="dialog-form" title="Einstellungen">
                        <form id="autores-form" role="form">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" id="aktiv" name="aktiv"> Einschalten
                                </label>
                            </div>


                            <div class="form-group">
                                <label for="from">Absender EMail-Adresse</label>
                                <select id="from" class="form-control" name="from">
                                    <?
                                        foreach($this->getUser()->getMailAdressen() as $email) {
                                            echo '<option value="'.$email.'">'.$email.'</option>';
                                        }
                                    ?>

                                </select>
                            </div>


                            <div class="form-group">
                                <label for="fromname">Absender-Name</label>
                                <input type="input" class="form-control" id="fromname" name="fromname" value="" placeholder="Gebe eine Absender-Namen ein!">
                            </div>


                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="singlesend" value="1" name="singlesend"> Single Send <p>Aktivieren Sie diese Option, wenn Sie wünschen, dass jeder Absender nur eine Benachrichtung erhält.</p>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="fromname">Betreff</label>
                                <input type="input" class="form-control" id="subject" name="subject" value="" placeholder="Geben Sie einen Betreff ein...">
                            </div>


                            <textarea class="form-control" name="text" id="text" rows="5"></textarea>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    <button type="button" class="btn btn-primary" id="save">Speichern</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="account-modal" tabindex="-1" role="dialog" aria-labelledby="account-model-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="account-modal-label"><span class="fa fa-edit"></span> Benutzerprofil von <strong><?=$this->getUser()->getUsername()?></strong></h4>
                </div>
                <div class="modal-body">
                    <div id="dialog-form">
                        <form id="account-edit-form" role="form">

                            <input type="hidden" id="id" name="id" value="<?=$this->getUser()->getId()?>">

                            <div class="row" data-toggle="popover" title="Hinweis" data-trigger="focus" data-content="Namensänderungen können nur von der Personalabteilung vorgenommen werden.">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Vorname</label>
                                        <input type="text" class="form-control not-allowed-cursor" id="vorname" name="vorname" value="<?=$this->getUser()->getVorname()?>" required readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control not-allowed-cursor" id="nachname" name="nachname" value="<?=$this->getUser()->getNachname()?>" required readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6">

                                </div>

                                <div class="col-lg-6">

                                </div>

                            </div>


                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="from">Straße</label>
                                        <input type="text" class="form-control" id="strasse" name="strasse" value="<?=$this->getUser()->getStrasse()?>" required placeholder="Enter a name.">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="from">Nr.</label>
                                        <input type="text" class="form-control" id="hausnr" name="hausnr" value="<?=$this->getUser()->getHausnr()?>" required placeholder="Enter a name.">
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="from">PLZ</label>
                                        <input type="text" class="form-control" id="plz" name="plz" value="<?=$this->getUser()->getPlz()?>" required placeholder="Enter a name.">
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label for="from">Ort</label>
                                        <input type="text" class="form-control" id="ort" name="ort" value="<?=$this->getUser()->getOrt()?>" required placeholder="Enter a name.">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-2" data-toggle="popover" data-placement="left" title="Hinweis" data-trigger="focus" data-content="Ihre Durchwahl wird automatisch aus der Telefonanlage übernommen.">
                                    <div class="form-group" >
                                        <label for="from">Durchwahl</label>
                                        <input type="text" class="form-control not-allowed-cursor"  id="telefonDurchwahl" name="telefonDurchwahl" value="<?=$this->getUser()->getTelefonDurchwahl()?>" required readonly>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group" >
                                        <label for="from"><span class="fa fa-phone"></span> Mobil</label>
                                        <input type="text" class="form-control" id="telefonMobil" name="telefonMobil" value="<?=$this->getUser()->getTelefonMobil()?>">
                                    </div>
                                </div>

                                <div class="col-lg-offset-1 col-lg-5">
                                    <div class="form-group" >
                                        <label for="from"><span class="fa fa-phone"></span> Privat</label>
                                        <input type="text" class="form-control" id="telefonPrivat" name="telefonPrivat" value="<?=$this->getUser()->getTelefonPrivat()?>">
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                    <button type="button" id="save" class="btn btn-success">Speichern</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="password-modal" tabindex="-1" role="dialog" aria-labelledby="password-model-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="password-modal-label"><span class="fa fa-lock"></span> Passwort von <strong><?=$this->getUser()->getUsername()?></strong> ändern</h4>
                </div>
                <div class="modal-body">
                    <div id="dialog-form">
                        <form id="account-edit-form" role="form">

                            <input type="hidden" id="id" name="id" value="<?=$this->getUser()->getId()?>">
                            <div class = "form-group" id="notifications">
                            </div>
                            <div class="form-group" style="margin-bottom: 5%">
                                <input type="password" class="form-control" id="currentPassword" name="currentPassword" value="" placeholder="Altes Passwort">
                            </div>

                            <div class="form-group" >
                                <input type="password" class="form-control" id="newPassword" name="newPassword" value="" placeholder="Neues Passwort">
                            </div>
                            <div class="form-group" >
                                <input type="password" class="form-control" id="newPasswordRepeated" name="newPasswordRepeated" value="" placeholder="Neues Passwort erneut eingeben">
                            </div>


                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                    <button type="button" id="save" class="btn btn-danger">Passwort ändern</button>
                </div>
            </div>
        </div>
    </div>

</div>

