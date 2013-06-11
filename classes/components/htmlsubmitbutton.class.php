<?php
namespace phpframework\components;

/**
 * Represents an HTML SubmitButton
 * 
 * Provides submitButton specific methods
 * @author Christian Thommen
 */
class HTMLSubmitButton extends HTMLButton{
	/**
	 * Creates a new instance
	 * 
	 * @param string $name The name/label of this button, default is "Submit"
	 * @return HTMLSubmitButton object
	 */
	public function __construct($name = "Submit"){
       parent::__construct($name);
	   $this->setType("submit");
	}
}
?>