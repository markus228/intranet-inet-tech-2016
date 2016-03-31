<?php
/**
 * @var \view\NavigationTopView $this
 */
?>

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           <!-- <a class="navbar-brand" href="#"><?=$this->getNavbarBrand()?></a> -->
            <a href="<?=\router\RequestAnalyzer::getRedirectURL("start")?>" class="pull-left img-rounded img-responsive"><img src="resources/img/evil_corp.png" style="max-width:100px; margin-left: 15px; margin-top: 10px; margin-right:15px;">
            </a>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li><a href="<?=\router\RequestAnalyzer::getRedirectURL("")?>">Persönliche Statusseite</a></li>

                <!-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laufwerke<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li ><a href="<?=\router\RequestAnalyzer::getRedirectURL("files")?>">Privat-Laufwerk</a></li>
                    </ul>
                </li> -->

                <li ><a href="<?=\router\RequestAnalyzer::getRedirectURL("files")?>">Laufwerk</a></li>

                <li><a href="<?=\router\RequestAnalyzer::getRedirectURL("staffSearch")?>">Personensuche</a></li>

                <li><a href="<?=\router\RequestAnalyzer::getRedirectURL("faq")?>">FAQ</a></li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><div><a href="<?=\router\RequestAnalyzer::getRedirectURL("logout")?>" class="btn btn-danger btn-sm navbar-btn" style="margin-right: 15px"><span class="glyphicon glyphicon-log-out"></span> Logout</a></div></li>
            </ul>

        </div><!--/.nav-collapse -->
    </div>
</nav>
