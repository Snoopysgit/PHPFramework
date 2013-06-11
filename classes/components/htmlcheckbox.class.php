<?php
namespace phpframework\components;

/**
 * Represents an HTML Checkbox
 * 
 * Provides Checkbox specific methods
 * @author Christian Thommen
 */
class HTMLCheckbox extends HTMLInput{
	/**
	 * Creates a new instance
	 * 
	 * @param string $name The name/label of this checkbox, default is "Checkbox"
	 * @param boolean $required true, this field is marked as required. false, this field is not marked as required. default is false
	 * @return HTMLInput object
	 */
	public function __construct($required=false){
		parent::__construct();
		$this->setType("checkbox");
		$this->setRequired($required);
	}
	/**
	 * Set the state of this checkbox
	 * 
	 * @param boolean $checked true, if this checkbox should be checked. false if it should be unchecked
	 */
	public function setChecked($checked){
		if($checked){
			$this->addAttribute("checked","checked");
		}else{
			$this->removeAttribute("checked");			
		}
	}
	/**
	 * Check the state of this checkbox
	 * 
	 * Look out! this function checks the Posted state of this checkbox and not the possible manually value set in code!
	 * @return boolean true, if this checkbox is checked. false if it is unchecked
	 */
	public function isChecked(){
		if(isset($_POST[$this->getName()])){
			return true;
		}else{
			return false;
		}
	}
}
?>