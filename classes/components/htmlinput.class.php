<?php
class HTMLInput extends HTMLComponent{
	public function __construct($name="", $type = "text", $placeholder = "", $value="", $required=false){
		parent::__construct();
		$this->setTag("input");
		
		$this->setName($name);
		$this->setType($type);
		$this->setPlaceholder($placeholder);
		$this->setValue($value);
		$this->setRequired($required);
	}
	public function refreshHTML(){
		// inputs haben keinen inhalt
	}
	public function setPlaceholder($placeholder){
		if($placeholder != ""){
			$this->addAttribute("placeholder",$placeholder);
		}	
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
	public function setValue($value){
		$this->addAttribute("value",$value);
	}
	public function getValue(){
		if(isset($_POST[$this->getName()])){
			return $_POST[$this->getName()];
		}else{
			return $this->getAttribute("value");
		}
	}
	public function setType($type){
		$this->addAttribute("type",$type);
	}
	public function getType(){
		return $this->getAttribute("type");
	}
	public function setRequired($required){
		if($required){
			$this->addAttribute("required","required");
		}else{
			$this->removeAttribute("required");			
		}
	}
	public function setDisabled($disabled){
		if($disabled){
			$this->addAttribute("disabled","disabled");
		}else{
			$this->removeAttribute("disabled");			
		}
	}
}
?>