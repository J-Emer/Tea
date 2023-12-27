<?php

use Jemer\Tea\PathHelper;
use Symfony\Component\Yaml\Yaml;

require "vendor/autoload.php";

$path = __DIR__ . DIRECTORY_SEPARATOR . "\Content\Posts";

$categories = PathHelper::GetDirectories($path);

foreach ($categories as $category) 
{
    $dirPath = $path . DIRECTORY_SEPARATOR . $category;

    $files = RemoveList(PathHelper::GetFiles($dirPath));

    $files = RemoveExtension($files);

    //var_dump($files);

    $data = BuildYamlArray($category, $files);

    $savePath = $dirPath . DIRECTORY_SEPARATOR . "list.yaml";

    file_put_contents($savePath, $data);
}



function BuildYamlArray(string $category, array $posts)
{
    $array = [
        "title" => "list",
        "template" => "list",
        "category" => $category,
        "posts" => $posts,
    ];

    return Yaml::dump($array);
}
function RemoveList(array $files) : array
{
    $index = array_search('list.yaml', $files);
    unset($files[$index]);
    return $files;
}
function RemoveExtension(array $files) : array
{
    $data = [];

    foreach ($files as $file) 
    {
        $name = PathHelper::NamewithoutExtension($file);
        array_push($data, $name);
    }

    return $data;
}



?>