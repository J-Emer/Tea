<?php 

namespace Jemer\Tea;

use Directory;
use Jenssegers\Blade\Blade;
use Mni\FrontYAML\Parser;
use Bramus\Router\Router;
use Symfony\Component\Yaml\Yaml;

class Controller
{
    private $root;
    private $blade;
    private $config;


    public function __construct()
    {
        $this->root = App::GetInstance()->root;
        $this->blade = App::GetInstance()->blade;
        $this->config = App::GetInstance()->config;
    }

    /**
     * Runs the Home page that is set in the Config/site.json
     */
    public function index()
    {
        $path = $this->root . DIRECTORY_SEPARATOR . "Content" . $this->config->homepage;
        $this->LoadContent($path);
    }
    /**
     * Returns a page
     */
    public function pages()
    {
        $path = $this->root . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . $_SERVER['REQUEST_URI'] . ".md";
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
        $path = $this->root . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . $_SERVER['REQUEST_URI'] . ".md";
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
     * Returns a Post List (Category)
     */
    public function postlist()
    {
        $path = $this->root . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR . $_SERVER['REQUEST_URI'] . ".yaml";

        $yaml = Yaml::parseFile($path);
        
        echo $this->blade->render($this->config->theme . DIRECTORY_SEPARATOR . $yaml['template'], ["data" => $yaml, "site" => $this->config]);
    }
    private function LoadContent($file)
    {
        $parser = new Parser();
        $document = $parser->parse(file_get_contents($file));

        $yaml = $document->getYAML();
        $html = $document->getContent();

        echo $this->blade->render($this->config->theme . DIRECTORY_SEPARATOR . $yaml['template'], ["data" => $yaml, "content" => $html, "site" => $this->config]);
    }
    private function Load404()
    {
        echo $this->blade->render($this->config->theme . DIRECTORY_SEPARATOR . '404', []);
    }    
}

?>