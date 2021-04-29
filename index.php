<?php
mb_internal_encoding ( "UTF-8" );

function autoloadFunction($class){
    if (preg_match('/Controller$/', $class)){
        require("controllers/" . $class . ".php");
    }
    else if (preg_match('/Manager$/', $class)){
        require("models/" . $class . ".php");
    }
    else if (preg_match('/Core$/', $class)){
        require("config/Core/" . $class . ".php");
    }
    else
        require("config/Utility/" . $class . ".php");
}

spl_autoload_register("autoloadFunction");
// DbManager :: connect ( "127.0.0.1" , "root" , "" , "factura" );
$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));
$router->renderView();
