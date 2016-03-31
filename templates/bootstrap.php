<?php
/**
 * @var \view\BootstrapView $this
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->getTitle()?></title>

    <base href="<?=$this->getBaseUrl()?>">
    <!-- Bootstrap -->
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Global custom style for bootstrap -->
    <link href="resources/css/global.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="resources/css/<?=$this->getCss()?>" rel="stylesheet">



    <?=$this->getAdditionalHeader()?>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?=$this->getBodyContent()?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="vendor/components/jquery/jquery.min.js"></script>
<!-- jQuery UI (necessary for color anmiations etc.) -->
<script src="vendor/components/jqueryui/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

<?=$this->getContentPastJS()?>

<!-- Global custom JAVAScript file -->
<script src="resources/js/global.js"></script>




</body>
</html>