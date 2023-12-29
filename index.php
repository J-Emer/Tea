<?php

require "vendor/autoload.php";

use Bramus\Router\Router;
use Jemer\EventDispatcher\Manager;
use Jemer\Tea\App;
use Jemer\Tea\Controller;
use Jemer\Tea\RouteSchema;

define("ROOT", __DIR__);

App::GetInstance()->RegisterEvent("load", function()
{
    echo "<p>Load Event</p>";
});
App::GetInstance()->RegisterEvent("before_run", function()
{
    echo "<p>Before Run Event</p>";
});
App::GetInstance()->RegisterEvent("after_run", function()
{
    echo "<p>After Run Event</p>";
});
App::GetInstance()->RegisterEvent("before_render", function()
{
    echo "<p>Before Render Event</p>";
});
App::GetInstance()->RegisterEvent("after_render", function()
{
    echo "<p>After Render Event</p>";
});

App::GetInstance()->Run();


?>