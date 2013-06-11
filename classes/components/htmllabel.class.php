<?php
namespace phpframework\components;

/**
 * Represents an HTML Label
 * 
 * Provides label specific methods
 * @author Christian Thommen
 */
class HTMLLabel extends HTMLComponent{
	protected function getTagName(){
		return "label";
	}
	/**
	* Assigns an HTMLInput field to this HTMLLabel
	* 
	* If you click on the label it will jump to the assigned HTMLInput field. Basicly this method sets the "for" attribute of this HTML tag
	* @param HTMLInput An HTMLInput field to be referenced
	*/
	public function setField(HTMLInput $component){
		$this->setAttribute("for", $component->getElementId());
	}
}
?>