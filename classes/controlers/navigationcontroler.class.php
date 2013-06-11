<?php
namespace phpframework\controlers;
use phpframework\components\htmllink;
use phpframework\controlers\logincontroler;

/**
 * Navigation controler
 * 
 * Provides basic functionalities to handle navigation and content management
 * links content to navigators
 * Multiple categories can be used to initialize multiple navigation structures(menus)
 * Content can be assigned to a Navigator which is then displayed just if the Navigator is active
 * @author Christian Thommen
 */
class NavigationControler extends Controler{
	/**
	 * holds all navigators ordered by category
	 */
	private $navigatorsByCategory = array();
	/**
	 * holds all navigators ordered by Id
	 */
	private $navigatorsById = array();
	/**
	 * holds the default navigator
	 */
	private $defaultNavigator = null;
	
	/**
	 * Add a new Navigator to handle
	 * 
	 * @param Navigator $navigator Navigator object to add
	 */
	public function addNavigator(Navigator $navigator){
		if($navigator->getAccessRight() == "" or LoginControler::singleton()->hasAccessRight($navigator->getAccessRight()) or ($navigator->getAccessRight() == "LOGIN" and LoginControler::singleton()->isLoggedIn())){
			if(!is_array($this->navigatorsByCategory[$navigator->getDisplayCategory()])){
				$this->navigatorsByCategory[$navigator->getDisplayCategory()] = array();	
			}
			array_push($this->navigatorsByCategory[$navigator->getDisplayCategory()], $navigator);
			if(isset($_GET[$navigator->getDisplayCategory()]) and $_GET[$navigator->getDisplayCategory()] == $navigator->getId()){
				$navigator->setActive(true);
			}
			$this->navigatorsById[$navigator->getId()] = $navigator;
		}
	}
	/**
	 * Get all Navigators by Id
	 * 
	 * @return array(Navigator)|null an array of Navigators ordered by Id, or null if there are no Navigators
	 */
	public function getAllNavigators(){
		return $this->navigatorsById;
	}
	/**
	 * Get Navigators of a specific category
	 * 
	 * @return array(Navigator)|null an array of Navigators ordered by Id of one category, or null if there are no Navigators for this category
	 */
	public function getNavigatorsByCategory($category){
		if(isset($this->navigatorsByCategory[$category])){
			return $this->navigatorsByCategory[$category];
		}else{
			return null;
		}
	}
	/**
	 * Set the default Navigator
	 * 
	 * @param Navigator $defaultNavigator Navigator to set as default(fallback if no other Navigator is active)
	 */
	public function setDefaultNavigator($defaultNavigator){
		$this->defaultNavigator = $defaultNavigator;
	}
	/**
	 * Get the default Navigator
	 * 
	 * @return Navigator|null the default Navigator or null if it is not set yet
	 */
	public function getDefaultNavigator(){
		return $this->defaultNavigator;
	}
	/**
	 * Get a Navigator by Id
	 * 
	 * @param integer $id id of the Navigator toget
	 * @return Navigator|null the Navigator with the id or null if it is not present
	 */
	public function getNavigatorById($id){
		if(isset($this->navigatorsById[$id])){
			return $this->navigatorsById[$id];
		}else{
			return null;
		}
	}
	/**
	 * Get the selected Navigator
	 * 
	 * @category string $category (optional if categories are used) if provided, it will search just a specific category
	 * @return Navigator|null the Navigator which is active/selected, if nothing is selected defaultNavigator will be returned. 
	 * If no default is specified null will be returned
	 */
	public function getSelectedNavigator($category = ""){
		if($category == ""){
			$navigators = $this->getAllNavigators();
		}else{
			$navigators = $this->getNavigatorsByCategory($category);		
		}
		foreach($navigators as $navigator){
			if($navigator->isActive()){
				return $navigator;
			}
		}
		return $this->getDefaultNavigator();
	}
	/**
	 * Get the whole link of the current page
	 * 
	 * @return string the URL string of the current page
	 */
	public function getCurrentLink(){
		if($this->getSelectedNavigator()){
			return $_SERVER["PHP_SELF"].$this->getSelectedNavigator()->getHTMLLink()->getLink();
		}
	}
}

/**
 * Navigator Interface
 * 
 * Interface to be implemented, if the class should be Navigatable
 * @author Christian Thommen
 */
interface NavigatorInterface{
	/**
	 * Get the HTMLLink of this Navigator
	 * 
	 * @param string $name name of the link
	 * @return HTMLLink ojbect to navigate to this Navigator
	 */
	public function getHTMLLink($name);
	/**
	 * Get the state of this Navigator
	 * 
	 * @return boolean true, if the Navigator is active, false if not
	 */
	public function isActive();
	/**
	 * Get the displayName of this Navigator
	 * 
	 * @return string the name of this Navigator
	 */
	public function getDisplayName();
}
/**
 * Navigator
 * 
 * @author Christian Thommen
 */
class Navigator implements NavigatorInterface{
	/**
	 * id
	 */
	private static $idCount = 0;
	
	/**
	 * holds the displayName of this Navigator
	 */
	private $displayName;
	/**
	 * holds the cateogry of this Navigator
	 */
	private $category;
	/**
	 * holds the id of this Navigator
	 */
	private $id;
	/**
	 * holds the state of this Navigator
	 */
	private $isActive;
	/**
	 * holds the needed accessRight of this Navigator
	 */
	private $accessRight;
	
	/**
	 * Creates a new Instance
	 * 
	 * @param string $displayName name to display
	 * @param string $displayCategory category to be part of
	 * @param string $accessRight needed accessRight to navigate to this Navigator
	 */
	public function __construct($displayName, $displayCategory, $accessRight = ""){
		$this->setDisplayName($displayName);
		$this->setDisplayCategory($displayCategory);
		$this->setId();
		$this->setAccessRight($accessRight);
	}
	/**
	 * Set the displayName
	 */
	private function setDisplayName($displayName){
		$this->displayName = $displayName;
	}
	/**
	 * Set the DisplayCategory
	 */
	private function setDisplayCategory($displayCategory){
		$this->displayCategory = $displayCategory;
	}
	/**
	 * Set the Id
	 */
	private function setId(){
		$this->id = Navigator::$idCount++;
	}
	/**
	 * Set the needed AccessRight for this Navigator
	 */
	private function setAccessRight($accessRight){
		$this->accessRight = $accessRight;
	}
	/**
	 * Get the needed AccessRight for this Navigator
	 * 
	 * @return string accessRight needed to be allowed to navigate to this Navigator
	 */
	public function getAccessRight(){
		return $this->accessRight;
	}
	/**
	 * Get displayName
	 * 
	 * @return string the displayName of this Navigator
	 */
	public function getDisplayName(){
		return $this->displayName;
	}
	/**
	 * Get displayCategory
	 * 
	 * @return string the displayCategory of this Navigator
	 */
	public function getDisplayCategory(){
		return $this->displayCategory;
	}
	/**
	 * Get Id
	 * 
	 * @return integer the id of this Navigator
	 */
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
	/**
	 * Set the state of this Navigator
	 * 
	 * @param boolean $selected true, to select the Navigator, false to unselect it
	 */
	public function setActive($selected){
		$this->isActive = $selected;
	}
}
?>