<?php
namespace phpframework\modules;
use phpframework\components\htmlcontainer;
use phpframework\components\htmllist;
use phpframework\components\htmllistitem;
use phpframework\components\htmltext;
use phpframework\controlers\navigationcontroler;
use phpframework\controlers\navigator;
use phpframework\controlers\logincontroler;

class Menu extends HTMLList{
	private $menuName;
	public function __construct($menuName){
		parent::__construct();
		$this->menuName = $menuName;
		$this->initComponents($menuName);
	}
	private function initComponents($menuName){
		$this->addClassName("nav");
		$this->addClassName("nav-list");
		$navHeader = new HTMLListItem();
		$navHeader->addClassName("nav-header");
		$navHeader->addContent($menuName);
		$this->addContent($navHeader);
		
	}
	public function addNavigator(Navigator $navigator, $accessRight = ""){
		if($accessRight == "" or LoginControler::singleton()->hasAccessRight($accessRight) or ($accessRight == "LOGIN" and LoginControler::singleton()->isLoggedIn())){
			NavigationControler::singleton()->addNavigator($navigator);
			$listItem = new HTMLListItem();
			if($navigator->isActive()){
				$listItem->setActive(true);
			}
			$listItem->addContent($navigator->getHTMLLink());
			$this->addContent($listItem);
		}
	}
	public function getMenuName(){
		return $this->menuName;
	}
} 

?>