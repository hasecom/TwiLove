<?php 
namespace App\Connection;
require_once(__DIR__."/../Configuration.php");
use \PDO;
use App\Configuration;
use PDOException;

class Connection{
    private static $dbh;
    public static function pdo(){
        $dsn = 'mysql:dbname='.Configuration::get('DB_NAME').';host='.Configuration::get('DB_HOST');
        $user = Configuration::get('DB_USER');
        $password = Configuration::get('DB_PASSWORD');
        self::$dbh = new PDO($dsn, $user, $password);
    }
    public function con($sql,$param = null){
        self::pdo();
        
        try {
            $sth = self::$dbh->prepare("$sql");
            if($param != null){
                  foreach($param as $key => $val){                    
                    if(($key == 'ROW_NUM' || $key == 'FROM_NUM' ) && $val != null){
                        $sth->bindValue( ':'.$key, (int)$val, PDO::PARAM_INT );
                    } else if($val != null){
                        $sth->bindValue(':'.$key,$val);
                    }else{
                        $sth->bindValue(':'.$key, null, PDO::PARAM_NULL);
                    }
                }
            }
            $flag = $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            if($result == null) return $result;
            return $result;
        } catch(PDOException $e){
            exit;
        }
    }
}
?>