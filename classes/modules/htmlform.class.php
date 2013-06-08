<?php
namespace phpframework\modules;
use phpframework\components\HTMLComponent;
use phpframework\controlers\NavigationControler;

class HTMLForm extends HTMLComponent{
	protected function getTagName(){
		return "form";
	}
	public function __construct($name = "", $action = "", $method = "POST"){
		parent::__construct();
		$this->addAttribute("method", $method);
		$this->setName($name);
		if($action == ""){
			$action= NavigationControler::singleton()->getCurrentLink();
		}
		$this->addAttribute("action", $action);
		$this->addAttribute("value", "true");
	}
	public function getName(){
		return $this->getAttribute("name");
	}
	public function setName($name){
		if($name == ""){
			$this->addAttribute("name", $this->getElementId());		
		}else{
			$this->addAttribute("name",$name);
		}
	}
}
?>