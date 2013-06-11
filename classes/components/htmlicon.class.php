<?php
namespace phpframework\components;

/**
 * Represents an HTML Icon
 * 
 * This class can be used to add Icons to the page.
 * ! attention ! This class requires bootstrap to be active!
 * sample:
 * <code>
 * $icon = new HTMLIcon("icon-home");
 * print $icon;
 * </code>
 * @author Christian Thommen
 */
class HTMLIcon extends HTMLComponent{
	protected function getTagName(){
		return "i";
	}
	/**
	 * Creates a new instance
	 * 
	 * @param string $icon The name of the icon that should be used. 
	 * It will add the provided string as className to this object. Possible icons can be found in the bootstrap documentation.
	 * samples: "icon-home", "icon-user", "icon-list"
	 * @return HTMLIcon object
	 */
	public function __construct($icon = ""){
       parent::__construct();
	   $this->addClassName($icon);
	}
}
?>