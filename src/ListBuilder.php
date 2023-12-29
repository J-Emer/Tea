<?php 

namespace Jemer\Tea;

use Jemer\Tea\PathHelper;
use Symfony\Component\Yaml\Yaml;


class ListBuilder
{

    private $postPath;

    public function  __construct()
    {
        $this->postPath = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "Content\Posts";
    }

    /**
     * Builds a list of categories
     */
    public function BuildCategoriesList()
    {

    }

    /**
     * Builds a list of all post for a specific category
     */
    public function BuildPostList()
    {
        $categories = PathHelper::GetDirectories($this->postPath);

        foreach ($categories as $category) 
        {
            $dirPath = $this->postPath . DIRECTORY_SEPARATOR . $category;
        
            $files = $this->RemoveList(PathHelper::GetFiles($dirPath));
        
            $files = $this->RemoveExtension($files);
        
            //var_dump($files);
        
            $data = $this->BuildYamlArray($category, $files);
        
            $savePath = $dirPath . DIRECTORY_SEPARATOR . "list.yaml";
        
            file_put_contents($savePath, $data);
        }        
    }

    private function BuildYamlArray(string $category, array $posts)
    {
        $array = [
            "title" => "list",
            "template" => "list",
            "category" => $category,
            "posts" => $posts,
        ];
    
        return Yaml::dump($array);
    }

    private function RemoveList(array $files) : array
    {
        $index = array_search('list.yaml', $files);
        unset($files[$index]);
        return $files;
    }
    
    private function RemoveExtension(array $files) : array
    {
        $data = [];
    
        foreach ($files as $file) 
        {
            $name = PathHelper::NamewithoutExtension($file);
            array_push($data, $name);
        }
    
        return $data;
    }    
}

?>