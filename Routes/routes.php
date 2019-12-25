<?php 
namespace Routes;
class Routes{
    public function Action($fnc,$root,$controller,$request){
        if($_SERVER['REDIRECT_URL'] == "$root"){
            require_once(__DIR__.'/../App/Controllers/'.$controller.'.php');
            $class = 'App\\Controllers\\'.$controller;
            $obj = new $class;
            $obj->$fnc($request);
        }
    }
}
?>