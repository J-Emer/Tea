<?php 

namespace Jemer\Tea;


class PathHelper
{

    public static function DirectoryName(string $path) : string 
    {
        return pathinfo($path)['dirname'];
    }
    public static function NamewithExtension(string $path) : string 
    {
        return pathinfo($path)['basename'];
    }
    public static function NamewithoutExtension(string $path) : string 
    {
        return pathinfo($path)['filename'];
    }
    public static function Extension(string $path) : string 
    {
        return pathinfo($path)['extension'];
    }    

    /**
     * Builds a file system path from an array of parts.
     * Used to cut down on concatinization in code
     */
    public static function BuildPath(array $arr) : string
    {
        $str = "";

        foreach ($arr as $key) 
        {
            $str .= $key . DIRECTORY_SEPARATOR;
        }

        return rtrim($str, DIRECTORY_SEPARATOR);
    }
    /**
     * Returns all Files inside of a parent directory
     */
    public static function GetFiles(string $directory) : array
    {
        $files = [];

        $data = array_diff(scandir($directory), array(".", ".."));

        foreach ($data as $file) 
        {
            $path = $directory . DIRECTORY_SEPARATOR . $file;

            if(is_file($path))
            {
                array_push($files, $file);
            }
        }

        return $files;
    }
    /**
     * Returns all Directories inside of a parent directory
     */
    public static function GetDirectories(string $directory) : array
    {
        $directories = [];

        $data = array_diff(scandir($directory), array(".", ".."));

        foreach ($data as $dir) 
        {
            $path = $directory . DIRECTORY_SEPARATOR . $dir;

            if(is_dir($path))
            {
                array_push($directories, $dir);
            }
        }

        return $directories;
    }    
}

?>