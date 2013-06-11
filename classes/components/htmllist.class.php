<?php
namespace phpframework\components;

/**
 * Represents an HTML List
 * 
 * Provides list specific methods
 * @author Christian Thommen
 */
class HTMLList extends HTMLComponent{
	protected function getTagName(){
		return "ul";
	}
}
/**
 * Represents an HTML ListItem
 * 
 * Provides listItem specific methods
 * @author Christian Thommen
 */
class HTMLListItem extends HTMLComponent{
	protected function getTagName(){
		return "li";
	}
	/**
	 * Set this listItem as active
	 * 
	 * adds the className "active" if this listItem is active
	 * @param boolean $active true, if the item should appear as active, false if not.
	 */
	public function setActive($active){
		if($active){
			$this->addClassName("active");
		}else{
			$this->removeClassName("active");
		}
	}
}
?>