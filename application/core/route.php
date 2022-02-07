<?php
class Route
{
    static function start()
    {
        global $server;

        $appErr = null;

        session_start();

        if($_GET["lang"]=="en"){
            $_SESSION["lang"] = "en";
        }elseif($_GET["lang"]=="rus"){
            $_SESSION["lang"] = "rus";
        }elseif(!$_SESSION["lang"]){
            $_SESSION["lang"]="rus";
        }
        if(isset($_GET['cmd']) and $_GET['cmd']=='exit'){

            session_unset ();
            if($server['reqUri']['path']){
                header("Location: ".$server['reqUri']['path']);
            }else{
                header("Location: /");
            }
        }
        else{

            // default
            $controller_name = 'Main';
            $action_name = 'index';
            $routes = explode('?', $_SERVER['REQUEST_URI'])[0];
            $routes = explode('/', $routes);

            if ( !empty($routes[1]) ){
                $controller_name = $routes[1];
            }

            if ( !empty($routes[2]) ){
                $action_name = $routes[2];
            }

            $model_name = 'Model_'.$controller_name;
            $controller_name = 'Controller_'.$controller_name;
            $action_name = 'action_'.$action_name;

            $model_file = strtolower($model_name).'.php';
            $model_path = "application/models/".$model_file;
            if(file_exists($model_path))
            {
                include "application/models/".$model_file;
            }

            $controller_file = strtolower($controller_name).'.php';

            $controller_path = "application/controllers/".$controller_file;


            if(file_exists($controller_path)){
                include "application/controllers/".$controller_file;

            }
            else{
                $appErr["404"]["description"] = "unknown contoller mvc";
                throwErr($appErr);
            }
            $controller = new $controller_name;
            $action = $action_name;
            if(method_exists($controller, $action)){

            }
            else{
                $appErr["404"]["description"] = "Маршрут: контроллер '".$controller_name."' action '".$action."' не существует";
                $appErr["404"]["description_en"] = "Route: '".$controller_name."' contoller's action '".$action."' not exist";
                throwErr($appErr);
                //$action = "action_index";
            }
            $controller->$action();
        }
    }
}