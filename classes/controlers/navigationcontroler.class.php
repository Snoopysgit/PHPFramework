<?php
namespace phpframework\controlers;
use phpframework\components\htmllink;

class NavigationControler extends Controler{
	private $navigatorsByCategory;
	private $navigatorsById;
	
	protected function __construct(){
		parent::__construct();
		$this->navigatorsById = array();
		//$this->navigatorsByCategory = array();		
	}
	public function addNavigator(Navigator $navigator){
		if(!is_array($this->navigatorsByCategory[$navigator->getDisplayCategory()])){
			$this->navigatorsByCategory[$navigator->getDisplayCategory()] = array();	
		}
		array_push($this->navigatorsByCategory[$navigator->getDisplayCategory()], $navigator);
		if(isset($_GET[$navigator->getDisplayCategory()]) and $_GET[$navigator->getDisplayCategory()] == $navigator->getId()){
			$navigator->setActive(true);
		}
		$this->navigatorsById[$navigator->getId()] = $navigator;
	}
	public function getAllNavigators(){
		return $this->navigatorsById;
	}
	public function getNavigatorsByCategory($category){
		if(isset($this->navigatorsByCategory[$category])){
			return $this->navigatorsByCategory[$category];
		}else{
			return null;
		}
	}
	public function getNavigatorById($id){
		if(isset($this->navigatorsById[$id])){
			return $this->navigatorsById[$id];
		}else{
			return null;
		}
	}
	public function getSelectedNavigator(){
		foreach($this->getAllNavigators() as $navigator){
			if($navigator->isActive()){
				return $navigator;
			}
		}
	}
	public function getCurrentLink(){
		if($this->getSelectedNavigator()){
			return $_SERVER["PHP_SELF"].$this->getSelectedNavigator()->getHTMLLink()->getLink();
		}
	}
}
class Navigator implements NavigatorInterface{
	private static $idCount = 0;
	
	private $displayName;
	private $category;
	private $id;
	private $isActive;
	
	public function __construct($displayName, $displayCategory){
		$this->setDisplayName($displayName);
		$this->setDisplayCategory($displayCategory);
		$this->setId();
	}
	private function setDisplayName($displayName){
		$this->displayName = $displayName;
	}
	private function setDisplayCategory($displayCategory){
		$this->displayCategory = $displayCategory;
	}
	private function setId(){
		$this->id = Navigator::$idCount++;
	}
	public function getDisplayName(){
		return $this->displayName;
	}
	public function getDisplayCategory(){
		return $this->displayCategory;
	}
	public function getId(){
		return $this->id;
	}
	public function getHTMLLink($name = ""){
		$link = new HTMLLink("?".$this->getDisplayCategory()."=".$this->getId());
		if($name != ""){
			$link->setText($name);
		}else{
			$link->setText($this->getDisplayName());
		}
		return $link;
	}
	public function isActive(){
		return $this->isActive;
	}
	public function setActive($selected){
		$this->isActive = $selected;
	}
}
interface NavigatorInterface{
	public function getHTMLLink($name);
	public function isActive();
	public function getDisplayName();
}
?>