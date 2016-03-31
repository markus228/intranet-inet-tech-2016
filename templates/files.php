<?php
/**
 * @var $this \view\FilesView
 */
?>
<div id="files" data-current-path="<?=\models\PathAuth::encodePath($this->getCurrentPath())?>">
    <noscript>

        <!--
        Seite bleibt bei abgeschalteten JavaScript nutzbar!
        -->
        <div class="alert alert-warning">
            <strong>Achtung!</strong> In ihrem Browser ist JavaScript nicht aktiv. <br> Unter Umständen können sie nicht alle Features dieser Seite nutzen.
        </div>
    </noscript>
    <table class="table nowrap" style="width: 100%">
        <thead>
            <tr>
                <th width="60%">Dateiname</th>
                <th>Typ</th>
                <th>Letzte &Auml;nderung</th>
                <th>Gr&ouml;&szlig;e</th>
            </tr>
        </thead>

        <tbody>
                <?=$this->parseTable()?>
        </tbody>
    </table>
</div>