<?php
class HTMLButton extends HTMLText{	
	public function __construct($text = "Button", $name = "", $value="true", $type="button"){
       parent::__construct($text);
	   $this->setTag("button");
	   $this->addClassName("btn");
	   
	   $this->setType($type);
	   $this->setValue($value);
	   $this->setName($name);
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
		if($value != ""){
			$this->addAttribute("value",$value);
		}
	}
	public function getValue(){
		return $this->getAttribute("value");
	}
	public function isActive(){
		return (isset($_POST[$this->getName()]) and $_POST[$this->getName()] == $this->getValue());
	}
	public function setType($type){
		$this->addAttribute("type",$type);
	}
}
?>