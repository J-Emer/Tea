<?php


require "vendor/autoload.php";

use Jemer\Tea\App;

define("ROOT", __DIR__);


//---Registers a "Load" event
App::GetInstance()->RegisterEvent("load", function()
{
    //todo: add code to run when App's load event fires
});


App::GetInstance()->Run();


?>