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
        
        $this->LoadEvents();

        $this->SetRoutes();
    }

    private function LoadEvents()
    {
        $path = PathHelper::BuildPath([ROOT, "Config", "events.json"]);
        $data = json_decode(file_get_contents($path));
        $this->eventManager = new Manager($data);
    }
    public function RegisterEvent(string $event, Closure $callback)
    {
        $this->eventManager->Register($event, $callback);
    }
    public function FireEvent(string $event)
    {
        $this->eventManager->FireEvent($event);
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
        $this->eventManager->FireEvent("load");
        $this->eventManager->FireEvent("before_run");
        $this->router->run();  
        $this->eventManager->FireEvent("after_run");
    }

}


?>