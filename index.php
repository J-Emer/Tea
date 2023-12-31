<?php


require "vendor/autoload.php";

use Bramus\Router\Router;
use Jemer\EventDispatcher\Manager;
use Jemer\Tea\App;
use Jemer\Tea\Controller;
use Jemer\Tea\RouteSchema;

define("ROOT", __DIR__);

//---Registers a "Load" event
App::GetInstance()->RegisterEvent("load", function()
{
    //todo: add code to run when App's load event fires
});


App::GetInstance()->Run();


?>