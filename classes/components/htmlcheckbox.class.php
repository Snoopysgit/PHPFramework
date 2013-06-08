<?php
namespace phpframework\components;

class HTMLCheckbox extends HTMLInput{
	public function __construct($content=null, $required=false){
		parent::__construct($content, "checkbox");
		$this->setType("checkbox");
		$this->setRequired($required);
	}
	public function setChecked($checked){
		if($checked){
			$this->addAttribute("checked","checked");
		}else{
			$this->removeAttribute("checked");			
		}
	}
	public function isChecked(){
		if(isset($_POST[$this->getName()])){
			return true;
		}else{
			return false;
		}
	}
}
?>