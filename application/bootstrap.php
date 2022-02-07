<?php
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

function throwErr($appErr){
    include "application/models/Alerts_model.php";
    include "application/controllers/Alerts_contoller.php";
    $controller = new Alerts_contoller($appErr);
    $controller->action_index();
    exit;
}
function appExit(){
    unset($_SESSION["alias"]);
    unset($_SESSION["account_id"]);
    unset($_SESSION["user_id"]);
    unset($_SESSION["groups"]);
    $_SESSION["photoLink"]="/img/popimg/avatar-default.png";
}

global $server;
$server['reqUri']=parse_url($_SERVER['REQUEST_URI']);
$server['reqUri_expl']=explode("/",$server['reqUri']['path']);
$server['redirUri']=parse_url($_SERVER['HTTP_REFERER']);
$server['redirUri_expl']=explode("/",$server['redirUri']['path']);

require_once 'core/route.php';
require_once ($_SERVER["DOCUMENT_ROOT"]."/source/DB_class.php");

Route::start();