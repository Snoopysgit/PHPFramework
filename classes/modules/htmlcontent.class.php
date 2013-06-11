<?php
namespace phpframework\modules;
use phpframework\controlers\NavigatorInterface;
use phpframework\controlers\NavigationControler;
use phpframework\components\HTMLContainer;

/**
 * Represents an HTML Content
 * 
 * Provides content specific methods
 * @author Christian Thommen
 */
class HTMLContent extends HTMLContainer{
	/**
	 * Add Content if navigator is active
	 * 
	 * Checks if the currently selected navigator is the navigator provided in the method. If yes, it will add the content, otherwise not
	 * @param HTMLComponent|string $HTMLComponent The HTMLComponent or a string to add
	 * @param NavigatorInterface $navigator the navigator to check against
	 */
	public function addContentIfNavigatorActive($HTMLComponent, NavigatorInterface $navigator){
		if(NavigationControler::singleton()->getSelectedNavigator() == $navigator){
			parent::addContent($HTMLComponent);
		}
	}
}
?>