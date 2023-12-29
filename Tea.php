<?php

use Jemer\Tea\ListBuilder;
use Jemer\Tea\PathHelper;
use Symfony\Component\Yaml\Yaml;

require "vendor/autoload.php";

$listBuilder = new ListBuilder();
$listBuilder->BuildPostList();


?>