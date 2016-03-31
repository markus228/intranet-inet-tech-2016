<?php
require 'vendor/autoload.php';


\core\Application::init();

$router = new router\ApplicationRouter(new \router\RequestAnalyzer($_GET, $_POST, $_SERVER['REQUEST_METHOD'], $_FILES));
echo $router->run();