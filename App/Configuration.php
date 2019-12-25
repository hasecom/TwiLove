<?php 
namespace App;
class Configuration{
    public static function get($val){
        return self::param($val);
    }
    private static function param($req){
        if($req == null) return;
        $envData = file_get_contents(__DIR__."/../.env");
        $arr = "";
        $envArr = explode("\n",$envData);
        $envVal = [];
        foreach($envArr as $key => $val){
            $arr = explode('=',$val);
            $envVal += array($arr[0]=>$arr[1]);
        }
        return $envVal[$req];
    }
}
?>