<?php
namespace phpframework\controlers;

/**
 * Base class for controlers
 * 
 * This abstract class provides controler specific base features
 * A controler a singleton class. The instance can bet get by calling classname::singleton()
 * @author Christian Thommen
 */
abstract class Controler{
	/**
	* holds the instance for each class
	*/
    private static $_instances = array();
	
	/**
	* Creates a new class specific instance
	*
	* It is protected to conform the singleton pattern
	*/
	protected function __construct(){
	
	}
	/**
	* Gets the class specific instance
	*
	*/
    public static function singleton() {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        return self::$_instances[$class];
    }
	/**
	* Clone
	*
	* @throws Exception clone is not allowed in a singleton pattern
	*/
    public function __clone()
    {
        throw new Exception('Clone ist nicht erlaubt.');
    }
	/**
	* Wakeup
	*
	* @throws Exception serialization is not allowed in a singleton pattern
	*/
    public function __wakeup()
    {
        throw new Exception('Deserialisierung ist nicht erlaubt.');
    }
}
?>