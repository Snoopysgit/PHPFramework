<?php
namespace phpframework\controlers;

abstract class Controler{

    private static $_instances = array();
	
	protected function __construct(){}
    public static function singleton() {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        return self::$_instances[$class];
    }
    public function __clone()
    {
        throw new Exception('Clone ist nicht erlaubt.');
    }
    public function __wakeup()
    {
        throw new Exception('Deserialisierung ist nicht erlaubt.');
    }
}
?>