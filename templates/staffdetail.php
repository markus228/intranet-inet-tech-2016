<?php
/**
 * @var $this \view\StaffDetailView
 */
?>

<div class="staff-details" style="<?=($this->getUser() instanceof \models\EmptyUser)?'display: none;':''?>">
    <div class="page-header" style="margin-top: 0px">
        <h4>
            <span class="staff-nachname"><?=$this->getUser()->getNachname()?></span>,
            <span class="staff-vorname"><?=$this->getUser()->getVorname()?></span>

        </h4>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h5 class="contact-headline">Durchwahl</h5>

        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">
            <span class="staff-telefonDurchwahl"><?=$this->getUser()->getTelefonDurchwahl()?></span>
        </div>
        <div class="col-md-1 col-md-offset-7 col-sm-1 col-sm-offset-7 col-xs-1 col-xs-offset-6">
            <a class="staff-telefonDurchwahl telephone" href="tel:<?=$this->getUser()->getTelefonDurchwahl()?>"><span class="fa fa-phone-square fa-large-icon"></span></a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h5 class="contact-headline">Mobil</h5>

        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">
            <span class="staff-telefonMobil"><?=$this->getUser()->getTelefonMobil()?></span>
        </div>

        <div class="col-md-1 col-md-offset-7 col-sm-1 col-sm-offset-7 col-xs-1 col-xs-offset-6">
            <a class="staff-telefonMobil telephone" href="tel:<?=$this->getUser()->getTelefonMobil()?>"><span class="fa fa-phone-square fa-large-icon"></span></a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h5 class="contact-headline">Privat</h5>

        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">
            <span class="staff-telefonPrivat"><?=$this->getUser()->getTelefonPrivat()?></span>
        </div>

        <div class="col-md-1 col-md-offset-7 col-sm-1 col-sm-offset-7 col-xs-1 col-xs-offset-6">
            <a class="staff-telefonPrivat telephone" href="tel:<?=$this->getUser()->getTelefonPrivat()?>"><span class="fa fa-phone-square fa-large-icon"></span></a>
        </div>
    </div>


    <div class="row" style="margin-top: 40px">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h5 class="contact-headline">EMail</h5>

        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">
            <span class="staff-mailAdressen">
                <?
                    $i = 0;
                    foreach($this->getUser()->getMailAdressen() as $email) {
                        echo ($i == 0?'':'<br>').$email;
                        $i++;
                    }
                ?>
            </span>
        </div>

        <div class="col-md-1 col-md-offset-7 col-sm-1 col-sm-offset-7 col-xs-1 col-xs-offset-6">
            <span class="staff-mailAdressenLinks">
                            <?
                            for($j = 0;$j < $i;$j++) {
                                echo '<a href=""><span class="fa fa-envelope-o fa-large-icon"></span></a>';
                                if ($j != 0) echo "<br>";
                            }
                            ?>
            </span>

        </div>
    </div>

    <div class="row" style="margin-top: 40px">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h5 class="contact-headline">Adresse</h5>
        </div>
        <div class="col-md-4 col-sm-4 col-sm-4 col-xs-4">
            <address style="margin-bottom:0px;">
                    <span class="staff-strasse"><?=$this->getUser()->getStrasse()?></span> <span class="staff-hausnr"><?=$this->getUser()->getHausnr()?></span> <br>
                    <span class="staff-plz"><?=$this->getUser()->getPlz()?></span> <span class="staff-ort"><?=$this->getUser()->getOrt()?></span>
            </address>
        </div>

        <div class="col-md-1 col-md-offset-7 col-sm-1 col-sm-offset-7 col-xs-1 col-xs-offset-6">
            <a class="staff-map" href="#"><span class="fa fa-map-marker fa-large-icon"></span></a>
        </div>
    </div>
</div>
