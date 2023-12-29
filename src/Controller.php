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
        $path = PathHelper::BuildPath([$this->root, "Content", $this->config->homepage]);
        $this->LoadContent($path);
    }
    /**
     * Returns a page
     */
    public function pages()
    {
        $path = PathHelper::BuildPath([$this->root , "Content" , $_SERVER['REQUEST_URI'] . ".md"]);

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
        $path = PathHelper::BuildPath([$this->root , "Content" , $_SERVER['REQUEST_URI'] . ".md"]);

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
        $uriPath = str_replace("/category", "Posts", $_SERVER['REQUEST_URI']);

        $path = PathHelper::BuildPath([$this->root , "Content" , $uriPath . "/list.yaml"]);

        $yaml = Yaml::parseFile($path);
        
        echo $this->blade->render($yaml['template'], 
                                                    [
                                                        "data" => $yaml, 
                                                        "site" => $this->config,
                                                        "categories" => $this->GetCategories()
                                                    ]);        
    }
    private function LoadContent($file)
    {
        $parser = new Parser();
        $document = $parser->parse(file_get_contents($file));

        $yaml = $document->getYAML();
        $html = $document->getContent();

        echo $this->blade->render($yaml['template'], 
                                                    [
                                                        "data" => $yaml, 
                                                        "content" => $html, 
                                                        "site" => $this->config,
                                                        "categories" => $this->GetCategories()
                                                    ]);
    }
    private function Load404()
    {
        echo $this->blade->render('404', []);
    } 

    protected function GetCategories()
    {
        $path = $this->root . DIRECTORY_SEPARATOR . "\Content\Posts";

        return PathHelper::GetDirectories($path);
    }


    // public function mainlist()
    // {
    //     $categories = PathHelper::GetDirectories(PathHelper::BuildPath([
    //         $this->root,
    //         "Content",
    //         "Posts"
    //     ]));
    // }   
}

?>