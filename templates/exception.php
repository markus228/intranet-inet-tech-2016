<?php
/**
 * @var \view\ExceptionView $this
 */
?>


<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center" style="font-size: 60px">500</h1>
            <h3 class="text-center font-bold">Entschuldigung, da ist etwas schief gelaufen.</h3>
        </div>
    </div>

    <div style="margin-top: 30px;" class="row">
        <div class="col-lg-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <b>Fehlermeldung</b>
                </div>
                <div class="panel-body">
                    <p><?=$this->getExceptionMessage()?></p>
                    <div>
                        <?=$this->getDevsInformation()?>
                    </div>
                </div>
                <div class="panel-footer">
                    <b><?=$this->getExceptionName()?></b>
                </div>
            </div>
        </div>
    </div>
</div>


