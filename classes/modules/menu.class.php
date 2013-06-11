<?php
namespace phpframework\modules;
use phpframework\components\HTMLContainer;
use phpframework\components\HTMLList;
use phpframework\components\HTMLListItem;
use phpframework\components\HTMLText;
use phpframework\controlers\NavigationControler;
use phpframework\controlers\Navigator;

/**
 * Represents an HTML Menu
 * 
 * Provides Menu specific methods
 * @author Christian Thommen
 */
class Menu extends HTMLList{
	/**
	 * Holds the name of this menu
	 */
	private $menuName;
	/**
	 * Creates a new instance
	 * 
	 * @param string $menuName The name of this menu
	 * @return HTMLDialog object
	 */
	public function __construct($menuName){
		parent::__construct();
		$this->menuName = $menuName;
		$this->initComponents();
	}
	/**
	 * Initialisiert die Komponenten des Menus
	 */
	private function initComponents(){
		$this->addClassName("nav");
		$this->addClassName("nav-list");
		$navHeader = new HTMLListItem();
		$navHeader->addClassName("nav-header");
		$navHeader->addContent($this->menuName);
		$this->addContent($navHeader);
	}
	public function getHTML(){
		foreach(NavigationControler::singleton()->getNavigatorsByCategory($this->getMenuName()) as $navigator){
			$this->addNavigator($navigator);
		}
		return parent::getHTML();
	}
	/**
	 * Adds a navigator to the menu
	 *
	 * @param Navigator $navigator a navigator element to add to the menu 
	 */
	private function addNavigator(Navigator $navigator){
		NavigationControler::singleton()->addNavigator($navigator);
		$listItem = new HTMLListItem();
		if(NavigationControler::singleton()->getSelectedNavigator() == $navigator){
			$listItem->setActive(true);
			$navigator->setActive(true);
		}
		$listItem->addContent($navigator->getHTMLLink());
		$this->addContent($listItem);
	}
	/**
	 * Get the menu name
	 *
	 * @return string The name of this menu
	 */
	public function getMenuName(){
		return $this->menuName;
	}
} 

?>