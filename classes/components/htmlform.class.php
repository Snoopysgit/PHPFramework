<?php
class HTMLForm extends HTMLContainer{
	
	public function __construct($name = "", $action = "", $method = "POST"){
		parent::__construct();
		$this->setTag("form");
		$this->addAttribute("method", "POST");
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