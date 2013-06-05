<?php
namespace phpframework\controlers;
use phpframework\orm\loginorm;
use phpframework\orm\personaccessrightorm;

class LoginControler extends Controler{
	private $login;
	private $accessRights;
	
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
	public function logIn($user, $pw){
		$params = array();
		$params["username"] = $user;
		$params["password"] = $pw;
		
		$curLogin = LoginORM::getSubset($params);
		if ($curLogin){
			$this->setLogin(reset($curLogin));
		}
	}
	public function logOut(){
		SessionControler::singleton()->resetSession();
		$this->login = null;
		$this->accessRights = null;
	}
	public function isLoggedIn(){
		if (isset ($_SESSION[LoginORM::getIdName()])){
			return true;
		}else{
			return false;
		}
	}
	public function getLogin(){
		if($this->isLoggedIn()){
			return $this->login[$_SESSION[LoginORM::getIdName()]];
		}else{
			return null;
		}
	}
	private function setLogin($login){
		$this->login[$login->getId()] = $login;
		SessionControler::singleton()->setValue(LoginORM::getIdName(), $login->getValue(LoginORM::getIdName()));	
		$this->setAccessRights($login);
	}
	private function setAccessRights($login){
		$params["idperson"] = $login->getId();
		$accessRights = PersonAccessRightORM::getSubset($params, "functionname");
		$this->accessRights = $accessRights;
	}
	public function hasAccessRight($functionName){
		if($functionName == "")
			return true;
		if(isset($this->accessRights[$functionName])){
			return true;
		}else{
			return false;
		}
	}
	public function getAccessRights(){
		return $this->accessRights;
	}
}
?>