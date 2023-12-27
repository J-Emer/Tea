<?php 

namespace Jemer\Tea;

use Directory;
use Jenssegers\Blade\Blade;
use Mni\FrontYAML\Parser;
use Bramus\Router\Router;
use Symfony\Component\Yaml\Yaml;

class App
{
    public $root;
    public $blade;
    public $config;
    public $router;

    private static $instance;

    public static function GetInstance()
    {
        if (self::$instance == null)
        {
          self::$instance = new App();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->root = ROOT;

        $this->blade = new Blade($this->root . DIRECTORY_SEPARATOR . "Theme", $this->root . DIRECTORY_SEPARATOR . "Theme/Cache");
    
        $this->config = json_decode(file_get_contents($this->root . DIRECTORY_SEPARATOR . "Config/site.json"));
    
        $this->Directives();
        $this->SetRoutes();
    }

    private function SetRoutes()
    {
        $this->router = new Router();

        $this->router->setNamespace('\Jemer\Tea');
        
        $this->router->get('/', "Controller@index"); //index
        $this->router->get('/pages/.*', "Controller@pages"); //pages
        
        // $router->get('/posts/list', "App@mainlist"); //---shows all of the post categories -> currently broken
        
        $this->router->get('/posts/.*/list', "Controller@postlist"); //categories
        $this->router->get('/posts/.*', "Controller@posts"); //post      
    }
    public function Run()
    {
        $this->router->run();  
    }

    private function Directives()
    {
        $this->blade->directive("Url", function()
        {
            return $this->config->url;
        });
        $this->blade->directive("Root", function()
        {
            return $this->root;
        });
        $this->blade->directive("Assets", function()
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Assets";
        });    
        $this->blade->directive("Css", function()
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Assets" . DIRECTORY_SEPARATOR . "Css";
        });      
        $this->blade->directive("Js", function()
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Assets" . DIRECTORY_SEPARATOR . "Js";
        });      
        $this->blade->directive("Images", function()
        {
            return $this->config->url . DIRECTORY_SEPARATOR . "Assets" . DIRECTORY_SEPARATOR . "Images";
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




    // public function index()
    // {   
    //     $path = $this->root . DIRECTORY_SEPARATOR . "Content" . $this->config->homepage;
    //     $this->LoadContent($path);
    // }
    // public function pages()
    // {
    //     $path = $this->root . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . $_SERVER['REQUEST_URI'] . ".md";
    //     if(file_exists($path))
    //     {
    //         $this->LoadContent($path);
    //     }
    //     else
    //     {
    //         $this->Load404();
    //     }
    // }
    // public function posts()
    // {
    //     $path = $this->root . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . $_SERVER['REQUEST_URI'] . ".md";
    //     if(file_exists($path))
    //     {
    //         $this->LoadContent($path);
    //     }
    //     else
    //     {
    //         $this->Load404();
    //     }
    // }  
    // public function postlist()
    // {
    //     $path = $this->root . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . $_SERVER['REQUEST_URI'] . ".yaml";

    //     $yaml = Yaml::parseFile($path);
        
    //     echo $this->blade->render($this->config->theme . DIRECTORY_SEPARATOR . $yaml['template'], ["data" => $yaml, "site" => $this->config]);
    
    //     //$this->LoadContent($path);
    // }  
    // // public function mainlist()
    // // {
    // //     $path = $this->root . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . "Posts" . DIRECTORY_SEPARATOR . "list.yaml";
        
    // //     $yaml = Yaml::parseFile($path);
        
    // //     echo $this->blade->render($this->config->theme . DIRECTORY_SEPARATOR . $yaml['template'], ["data" => $yaml, "site" => $this->config]);
    // // }    
    // private function LoadContent($file)
    // {
    //     $parser = new Parser();
    //     $document = $parser->parse(file_get_contents($file));

    //     $yaml = $document->getYAML();
    //     $html = $document->getContent();

    //     echo $this->blade->render($this->config->theme . DIRECTORY_SEPARATOR . $yaml['template'], ["data" => $yaml, "content" => $html, "site" => $this->config]);
    // }
    // private function Load404()
    // {
    //     echo $this->blade->render($this->config->theme . DIRECTORY_SEPARATOR . '404', []);
    // }
}


?>