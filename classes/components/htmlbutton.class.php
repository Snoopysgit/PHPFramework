<?php
namespace phpframework\components;

/**
 * Represents an HTML Button
 * 
 * Provides Button specific methods
 * @author Christian Thommen
 */
class HTMLButton extends HTMLInput{
	/**
	 * Creates a new instance
	 * 
	 * @param string $name The name/label of this button, default is "Button"
	 * @return HTMLButton object
	 */
	public function __construct($name = "Button"){
       parent::__construct();
	   $this->addClassName("btn");
	   $this->setValue($name);
	   $this->setType("button");
	}
	/**
	 * Check if this button has been pressed
	 * 
	 * @param string $name The name/label of this button, default is "Button"
	 * @param string $value The value of this button. The value can be evaluated on postback. Default is "true".
	 * @return boolean true if this button lead to a postback in a form. It evaluates if this button is contained in postback and if the value is set.
	 */
	public function isActive(){
		return (isset($_POST[$this->getName()]) and $_POST[$this->getName()] == $this->getValue());
	}
}
?>