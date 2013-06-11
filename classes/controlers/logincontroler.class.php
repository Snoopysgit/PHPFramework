<?php
namespace phpframework\controlers;
use phpframework\orm\loginorm;
use phpframework\orm\personaccessrightorm;

/**
 * Login controler
 * 
 * Provides login functionalities
 * @author Christian Thommen
 */
class LoginControler extends Controler{
	/**
	 * holds the login object for each instance
	 */
	private $login;
	/**
	 * holds the accessRights for this user
	 */
	private $accessRights;
	
	/**
	 * Creates a new instance
	 */
	protected function __construct(){
		parent::__construct();
		$this->login = array();
		
		if (SessionControler::singleton()->isValueSet(LoginORM::getIdName())){
			$result = LoginORM::getById(SessionControler::singleton()->getValue(LoginORM::getIdName()));
			if ($result){
				$this->setLogin($result);
			}
		}else{
			SessionControler::singleton()->resetSession();
		}
	}
	/**
	 * Log in
	 *
	 * Logs in a user
	 * @param string $user provide a username
	 * @param string $pw provide a password
	 */
	public function logIn($user, $pw){
		$params = array();
		$params["username"] = $user;
		$params["password"] = $pw;
		
		$curLogin = LoginORM::getSubset($params);
		if ($curLogin){
			$this->setLogin(reset($curLogin));
		}
	}
	/**
	 * Log out
	 *
	 * Logs out the current logged in user
	 */
	public function logOut(){
		SessionControler::singleton()->resetSession();
		$this->login = null;
		$this->accessRights = null;
	}
	/**
	 * Checks if a user is already logged in
	 *
	 * @return boolean true, if the user is logged in, false if not
	 */
	public function isLoggedIn(){
		if (isset ($_SESSION[LoginORM::getIdName()])){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Get the login object
	 *
	 * @return LoginORM|null null if not logged in, otherwise it will return a LoginORM object
	 */
	public function getLogin(){
		if($this->isLoggedIn()){
			return $this->login[$_SESSION[LoginORM::getIdName()]];
		}else{
			return null;
		}
	}
	/**
	 * Set the login object
	 */
	private function setLogin($login){
		$this->login[$login->getId()] = $login;
		SessionControler::singleton()->setValue(LoginORM::getIdName(), $login->getValue(LoginORM::getIdName()));	
		$this->setAccessRights($login);
	}
	/**
	 * Set the access Rights for this user
	 */
	private function setAccessRights($login){
		$params["idperson"] = $login->getId();
		$accessRights = PersonAccessRightORM::getSubset($params, "functionname");
		$this->accessRights = $accessRights;
	}
	/**
	 * Check if user has access Right
	 *
	 * @param string $functionName provide a functionName as string to check if this user has accessRight to this function
	 * @return boolean, true if provided string is empty or if the user has access rights to this function. false otherwise
	 */
	public function hasAccessRight($functionName){
		if($functionName == "")
			return true;
		if(isset($this->accessRights[$functionName])){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Get all access rights for this user
	 */
	public function getAccessRights(){
		return $this->accessRights;
	}
}
?>