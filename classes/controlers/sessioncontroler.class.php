<?php
namespace phpframework\controlers;

/**
 * Session controler
 * 
 * Provides basic functionalities to handle sessions
 * @author Christian Thommen
 */
class SessionControler extends Controler{
	
	/**
	 * Creates a new instance
	 * 
	 * initializes the session
	 */
	protected function __construct(){
		parent::__construct();
		$this->setSession();
	}
	/**
	 * Reset the session
	 * 
	 * destroy and reopen he current session
	 */
	public function resetSession(){
		session_destroy();
		$this->setSession();
	}
	/**
	 * Set the session
	 * 
	 * initializes the session. 
	 * Sets cookie timeout to 10minutes and starts the session
	 */
	public function setSession(){
		session_set_cookie_params(600, '/');
		session_name('generalHomepageSession');
		session_start();
		$this->setValue("session_id", session_id());
		
		if (isset($_COOKIE['generalHomepageSession'])){
			setcookie('generalHomepageSession', $_COOKIE['generalHomepageSession'], time() + 600, '/');
		}
	}
	/**
	 * Set a session key/value pair
	 * 
	 * @param string $key a key
	 * @param string $value a value
	 */
	public function setValue($key, $value){
		$_SESSION[$key] = $value;
	}
	/**
	 * Remove a specific key/value pair
	 * 
	 * @param string $key a key to remove from session
	 */
	public function removeValue($key){
		unset($_SESSION[$key]);
	}
	/**
	 * Get a specific value from a key
	 * 
	 * @param string $key a key to get from session
	 * @return string the value assigned to the key
	 */
	public function getValue($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			return "";
		}
	}
	/**
	 * Checks if a provided key exists
	 * 
	 * @param string $key a key to check from session
	 * @return boolean true, if the value is available, false if not
	 */
	public function isValueSet($key){
		return isset($_SESSION[$key]);
	}
}
?>