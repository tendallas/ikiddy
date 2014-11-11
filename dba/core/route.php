<?php
class Route
{
	
    static function start()
    {
        // контроллер и действие по умолчанию
        $action_name = 'main';
        
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if ( !empty($routes[2]) )
        {	
            $action_name = $routes[2];
        }

        // подцепляем файл с классом контроллера
        $action_file = $action_name.'.php';
        $action_path = $_SERVER['DOCUMENT_ROOT']."/dba/actions/".$action_file;
        if(file_exists($action_path))
        {
            include $action_path;
        }
        else
        {
            Route::ErrorPage404();
        }
    }
    
    function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/dba/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}
?>