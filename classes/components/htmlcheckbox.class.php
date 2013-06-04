<?php
class HTMLCheckbox extends HTMLInput{
	public function __construct($name="", $required=false){
		parent::__construct($name, "checkbox");
		$this->setTag("input");
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