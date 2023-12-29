<?php 

namespace Jemer\Tea;

use Directory;
use Jenssegers\Blade\Blade;
use Mni\FrontYAML\Parser;
use Bramus\Router\Router;
use Symfony\Component\Yaml\Yaml;

class Controller
{
    private $blade;
    private $config;


    public function __construct()
    {
        $this->config = App::GetInstance()->config;

        $themeDir = PathHelper::BuildPath([ROOT, "Theme", $this->config->theme]);
        $cacheDir = PathHelper::BuildPath([ROOT, "Theme", "Cache"]);

        $this->blade = new Blade($themeDir, $cacheDir);
        $this->Directives();
    }
    private function Directives()
    {
        $this->blade->directive("Url", function()
        {
            return $this->config->url;
        });
        $this->blade->directive("Root", function()
        {
            return ROOT;
        });
        $this->blade->directive("Assets", function()
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Assets";
        });    
        $this->blade->directive("Css", function(string $css){
            return $this->config->url . DIRECTORY_SEPARATOR . "Assets" . DIRECTORY_SEPARATOR . "Css" . DIRECTORY_SEPARATOR . $css;
        });    
        $this->blade->directive("Js", function(string $js)
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Assets" . DIRECTORY_SEPARATOR . "Js" . DIRECTORY_SEPARATOR . $js;
        });      
        $this->blade->directive("Images", function(string $img)
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Assets" . DIRECTORY_SEPARATOR . "Images" . DIRECTORY_SEPARATOR . $img;
        });      
        $this->blade->directive("Pages", function()
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . "Pages";
        });  
        $this->blade->directive("Posts", function()
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . "Posts";
        });                      
    }
    /**
     * Runs the Home page that is set in the Config/site.json
     */
    public function index()
    {
        $path = PathHelper::BuildPath([ROOT, "Content", $this->config->homepage]);
        $this->LoadContent($path);
    }
    /**
     * Returns a page
     */
    public function pages()
    {
        $path = PathHelper::BuildPath([ROOT , "Content" , $_SERVER['REQUEST_URI'] . ".md"]);

        if(file_exists($path))
        {
            $this->LoadContent($path);
        }
        else
        {
            $this->Load404();
        }
    }
    /**
     * Returns a post
     */
    public function posts()
    {
        $path = PathHelper::BuildPath([ROOT , "Content" , $_SERVER['REQUEST_URI'] . ".md"]);

        if(file_exists($path))
        {
            $this->LoadContent($path);
        }
        else
        {
            $this->Load404();
        }
    }
    /**
     * Returs a list of all posts that are in this category
     */
    public function category() 
    {
        App::GetInstance()->FireEvent("before_render");

        $uriPath = str_replace("/category", "Posts", $_SERVER['REQUEST_URI']);

        $path = PathHelper::BuildPath([ROOT , "Content" , $uriPath . "/list.yaml"]);

        $yaml = Yaml::parseFile($path);
        
        $this->Render($yaml['template'], 
                                        [
                                            "data" => $yaml, 
                                            "site" => $this->config,
                                            "categories" => $this->GetCategories()
                                        ]);
        
        App::GetInstance()->FireEvent("after_render");
    }
    private function LoadContent($file)
    {
        App::GetInstance()->FireEvent("before_render");

        $parser = new Parser();
        $document = $parser->parse(file_get_contents($file));

        $yaml = $document->getYAML();
        $html = $document->getContent();

        $this->Render($yaml['template'], 
                                        [
                                            "data" => $yaml, 
                                            "content" => $html, 
                                            "site" => $this->config,
                                            "categories" => $this->GetCategories()
                                        ]);

        App::GetInstance()->FireEvent("after_render");
    }
    private function Render(string $template, array $data)
    {
        echo $this->blade->render($template, $data);
    }
    private function Load404()
    {
        echo $this->Render('404', []);
    } 

    protected function GetCategories()
    {
        $path = ROOT . DIRECTORY_SEPARATOR . "\Content\Posts";

        return PathHelper::GetDirectories($path);
    }


    // public function mainlist()
    // {
    //     $categories = PathHelper::GetDirectories(PathHelper::BuildPath([
    //         ROOT,
    //         "Content",
    //         "Posts"
    //     ]));
    // }   
}

?>