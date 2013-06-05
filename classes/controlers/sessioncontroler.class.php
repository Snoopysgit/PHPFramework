<?php
namespace phpframework\controlers;

class SessionControler extends Controler{
	
	protected function __construct(){
		parent::__construct();
		$this->setSession();
	}
	public function resetSession(){
		session_destroy();
		$this->setSession();
	}
	public function setSession(){
		session_set_cookie_params(600, '/');
		session_name('generalHomepageSession');
		session_start();
		$this->setValue("session_id", session_id());
		
		if (isset($_COOKIE['generalHomepageSession'])){
			setcookie('generalHomepageSession', $_COOKIE['generalHomepageSession'], time() + 600, '/');
		}
	}
	public function setValue($key, $value){
		$_SESSION[$key] = $value;
	}
	public function removeValue($key){
		unset($_SESSION[$key]);
	}
	public function getValue($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			return "";
		}
	}
	public function isValueSet($key){
		return isset($_SESSION[$key]);
	}
}
?>