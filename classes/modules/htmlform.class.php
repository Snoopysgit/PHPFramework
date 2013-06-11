<?php
namespace phpframework\modules;
use phpframework\components\HTMLComponent;
use phpframework\controlers\NavigationControler;

/**
 * Represents an HTML Form
 * 
 * Provides form specific methods
 * @author Christian Thommen
 */
class HTMLForm extends HTMLComponent{
	protected function getTagName(){
		return "form";
	}
	/**
	 * Creates a new instance
	 * 
	 * @param string $name The name of this form
	 * @param string $action Action to perform. Default is the current location(postback)
	 * @param string $method Method to use on this form. Default is "POST"
	 * @return HTMLForm object
	 */
	public function __construct($action = "", $method = "POST"){
		parent::__construct();
		$this->addAttribute("method", $method);
		$this->setName();
		if($action == ""){
			$action= NavigationControler::singleton()->getCurrentLink();
		}
		$this->addAttribute("action", $action);
		$this->addAttribute("value", "true");
	}
	/**
	 * Get the name attribute
	 * 
	 * @return string The name of this form
	 */
	public function getName(){
		return $this->getAttribute("name");
	}
	/**
	 * Set the name attribute
	 * 
	 * @param string $name The name of this form. default sets it to the elementId
	 */
	public function setName($name = ""){
		if($name == ""){
			$this->addAttribute("name", $this->getElementId());		
		}else{
			$this->addAttribute("name",$name);
		}
	}
}
?>