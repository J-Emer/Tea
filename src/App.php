<?php 

namespace Jemer\Tea;

use Directory;
use Jenssegers\Blade\Blade;
use Mni\FrontYAML\Parser;
use Bramus\Router\Router;
use Closure;
use Jemer\EventDispatcher\Manager;
use Symfony\Component\Yaml\Yaml;

class App
{
    public $config;
    public $router;

    private $eventManager;

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
        $this->config = json_decode(file_get_contents(PathHelper::BuildPath([ROOT, "Config", "site.json"])));
        
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


        //-----------------------------------------Admin------------------------------------------------//


    }
    public function Run()
    {
        $this->router->run();  
    }

}


?>