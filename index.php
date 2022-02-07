<?php
$request_url = parse_url($_SERVER['REQUEST_URI']);
$request_path = explode("/", $request_url["path"]);

if($request_path[1] == "admin"){
    global $mct;
    $mct['start_time'] = microtime(true);
    require_once 'application/bootstrap.php';
}else{
    echo "use your site";
}







