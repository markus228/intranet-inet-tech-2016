<?php
/**
 * @var \view\DashboardContentView $this
 */
?>

<!-- Begin page content -->
<div class="container">
        <div class="page-header">
            <h2>
                <?=$this->getTitle()?>
                <small><?=$this->getSubheading()?></small>
            </h2>
        </div>
    <?=$this->getAlerts()?>
    <?=$this->getContent()?>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted"><?=$this->getFooter()?></p>
    </div>
</footer>
