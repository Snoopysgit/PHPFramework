<?php
namespace phpframework\components;

/**
 * Represents an HTML Input
 * 
 * Provides Input specific methods and is the base class for any kind of input field
 * @author Christian Thommen
 */
class HTMLInput extends HTMLComponent{
	protected function getTagName(){
		return "input";
	}
	/**
	 * Creates a new instance
	 * 
	 * @param string $name The name/label of this input. default is "Input"
	 * @param string $type Type of this checkbox(text, button, textarea, checkbox, ...). default is "text"
	 * @param string $placeholder Set the placeholder of a textfield. default is ""
	 * @param string $value Set the value of this Input to a specific value. default is ""
	 * @param boolean $required true, this field is marked as required. false, this field is not marked as required. default is false
	 * @return HTMLInput object
	 */
	public function __construct($type = "text", $placeholder = "", $value="", $required=false){
		parent::__construct();
		
		$this->setName();
		$this->setType($type);
		$this->setPlaceholder($placeholder);
		$this->setValue($value);
		$this->setRequired($required);
	}
	/**
	 * Set the placeholder attribute
	 * 
	 * Has an effect to text fields, can be used instead of label fields, to label a textfield.
	 * @param string $placeholder The name/label of this textfield
	 */
	public function setPlaceholder($placeholder){
		if($placeholder != ""){
			$this->addAttribute("placeholder",$placeholder);
		}	
	}
	/**
	 * Get the name attribute of this input field
	 * 
	 * @return string the current set name attribute of this field
	 */
	public function getName(){
		return $this->getAttribute("name");
	}
	/**
	 * Set the name attribute of this input field
	 * 
	 * @param string the name which should be set. If no string or empty string is provided, the name will be set to the elementId
	 */
	public function setName($name = ""){
		if($name == ""){
			$this->addAttribute("name", $this->getElementId());		
		}else{
			$this->addAttribute("name",$name);
		}
	}
	/**
	 * Set the value of this input to a specific value
	 * 
	 * @param string the value which should be set
	 */
	public function setValue($value){
		$this->addAttribute("value",$value);
	}
	/**
	 * Get the value of this input
	 * 
	 * Look out! this function checks the Posted state of this checkbox and not the possible manually value set in code!
	 * @return string the posted value of this input field or the previously assigned value
	 */
	public function getValue(){
		if(isset($_POST[$this->getName()])){
			return $_POST[$this->getName()];
		}else{
			return $this->getAttribute("value");
		}
	}
	/**
	 * Set the type of this input field
	 * 
	 * @param string $type The type of this input field. Adds the attribute type to the field. Possible values are (text, textarea, button, submitbutton, checkbox, ...)
	 */
	public function setType($type){
		$this->addAttribute("type",$type);
	}
	/**
	 * Get the type of this input field
	 * 
	 * @return string The type of this input field
	 */
	public function getType(){
		return $this->getAttribute("type");
	}
	/**
	 * Set the required attribute of this input field
	 * 
	 * @param boolean $required true, this field is marked as required. false, this field is not marked as required
	 */
	public function setRequired($required){
		if($required){
			$this->addAttribute("required","required");
		}else{
			$this->removeAttribute("required");			
		}
	}
	/**
	 * Set the disabled attribute of this input field
	 * 
	 * @param boolean $disabled true, this field is marked as disabled. false, this field is not marked as disabled
	 */
	public function setDisabled($disabled){
		if($disabled){
			$this->addAttribute("disabled","disabled");
		}else{
			$this->removeAttribute("disabled");			
		}
	}
}
?>