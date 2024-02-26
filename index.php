<?php


require "vendor/autoload.php";

use Jemer\Tea\Admin\AdminController;
use Jemer\Tea\App;

define("ROOT", __DIR__);


App::GetInstance()->Run();


?>