<?php

require "vendor/autoload.php";

use Bramus\Router\Router;
use Jemer\EventDispatcher\Manager;
use Jemer\Tea\App;
use Jemer\Tea\Controller;
use Jemer\Tea\RouteSchema;

define("ROOT", __DIR__);

App::GetInstance()->Run();


?>