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

        $this->config = json_decode(file_get_contents($this->root . DIRECTORY_SEPARATOR . "Config/site.json"));
    

        $themeDir = PathHelper::BuildPath([$this->root, "Theme", $this->config->theme]);
        $cacheDir = PathHelper::BuildPath([$this->root, "Theme", "Cache"]);


        //$this->blade = new Blade($this->root . DIRECTORY_SEPARATOR . "Theme", $this->root . DIRECTORY_SEPARATOR . "Theme/Cache");
        $this->blade = new Blade($themeDir, $cacheDir);
    

        $this->Directives();
        $this->SetRoutes();
    }

    private function SetRoutes()
    {
        $this->router = new Router();

        $this->router->setNamespace('\Jemer\Tea');
        
        $this->router->get('/', "Controller@index"); //index

        $this->router->get('/pages/.*', "Controller@pages"); //pages   
        
        $this->router->get('/category/.*', "Controller@category"); //categories

        $this->router->get('/posts/.*', "Controller@posts"); //post (shows an individual post)         
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
}


?>