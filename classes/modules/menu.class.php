<?php
namespace phpframework\modules;
use phpframework\components\htmlcontainer;
use phpframework\components\htmllist;
use phpframework\components\htmllistitem;
use phpframework\components\htmltext;
use phpframework\controlers\navigationcontroler;
use phpframework\controlers\navigator;
use phpframework\controlers\logincontroler;

class Menu extends HTMLContainer{
	private $menuName;
	
	public function __construct($menuName){
		parent::__construct();
		$this->menuName = $menuName;
	}
	public function refreshHTML(){
		$innerNav = new HTMLList();
		$innerNav->addClassName("nav");
		$innerNav->addClassName("nav-list");
		$navHeader = new HTMLListItem();
		$navHeader->addClassName("nav-header");
		$navHeader->addContent(new HTMLText($this->menuName));
		$innerNav->addContent($navHeader);
		
		$navigators = NavigationControler::singleton()->getNavigatorsByCategory($this->menuName);
		if($navigators != null){
			foreach($navigators as $navigator){
				$listItem = new HTMLListItem();
				if($navigator->isActive()){
					$listItem->setActive(true);
				}
				$listItem->addContent($navigator->getHTMLLink());
				$innerNav->addContent($listItem);
			}
		}
		$this->setInnerHTML($innerNav);
	}
	public function addNavigator(Navigator $navigator, $accessRight = ""){
		if($accessRight == "" or LoginControler::singleton()->hasAccessRight($accessRight) or ($accessRight == "LOGIN" and LoginControler::singleton()->isLoggedIn())){
			NavigationControler::singleton()->addNavigator($navigator);
		}
	}
	public function getMenuName(){
		return $this->menuName;
	}
} 

?>