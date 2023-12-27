<?php

require "vendor/autoload.php";

use Bramus\Router\Router;
use Jemer\Tea\App;

define("ROOT", __DIR__);

App::GetInstance()->Run();

?>