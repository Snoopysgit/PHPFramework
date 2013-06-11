<?php
namespace phpframework\modules;
use phpframework\components\htmlcontainer;
use phpframework\components\htmlbutton;
use phpframework\components\htmllink;
use phpframework\controlers\navigatorinterface;

/**
 * Represents an HTML Dialog
 * 
 * Provides dialog specific methods
 * @author Christian Thommen
 */
class HTMLDialog extends HTMLContainer implements NavigatorInterface{	
	/**
	 * Dialog header
	 */
	private $head;
	/**
	 * Dialog body
	 */
	private $body;
	/**
	 * Dialog foot
	 */
	private $foot;
	/**
	 * Dialog state
	 */
	private $active;
	
	/**
	 * Creates a new instance
	 * 
	 * @param HTMLComponent|string $content The content to add in the body of the dialog
	 * @return HTMLDialog object
	 */
	public function __construct($content = ""){
		parent::__construct();
		$this->initComponents($content);
		$this->addClassName("modal");
		$this->setActive(false);
		$this->addAttribute("role", "dialog");
		$this->addAttribute("aria-hidden", "true");
	}
	/**
	 * Initializes head, body and foot
	 */
	private function initComponents($content){
		$this->initHead();
		$this->initBody($content);
		$this->initFoot();
	}
	/**
	 * Initializes head
	 */
	private function initHead(){
		$this->head = new HTMLContainer();
		$this->head->addClassName("modal-header");
		
		$closeButton = new HTMLButton();
		$closeButton->setValue("&times;");
		$closeButton->addAttribute("data-dismiss", "modal");
		$closeButton->addAttribute("aria-hidden", "true");
		$closeButton->addClassName("close");
		$closeButton->setType("button");
		
		$this->head->addContent($closeButton, "head");
		$this->addContent($this->head);
	}
	/**
	 * Initializes body
	 */
	private function initBody($content){
		$this->body = new HTMLContainer($content);
		$this->body->addClassName("modal-body");
		$this->addContent($this->body);
	}
	/**
	 * Initializes foot
	 */
	private function initFoot(){
		$this->foot = new HTMLContainer();	
		$this->foot->addClassName("modal-footer");
		$this->addContent($this->foot);
	}
	/**
	* Adds content to this dialog. 
	* The content can be other HTMLComponents or classes which implements the magic method __toString()
	* To add multiple content at once you can also wrap multiple content objects within an array()
	*
	* @param string|HTMLComponent|array() $HTMLComponent single or multiple content objects to add
	* @param string $target Where should the content be added: "head", "body", "foot". Any other value, will add the content directly to this element.
	*/
	public function addContent($HTMLComponent, $target = "parent"){
		switch($target){
			case "head":
				$this->head->addContent($HTMLComponent);
				break;
			case "body":
				$this->body->addContent($HTMLComponent);
				break;
			case "foot":
				$this->foot->addContent($HTMLComponent);
				break;
			default:
				parent::addContent($HTMLComponent);
				break;
		}
	}
	/**
	* Get an HTMLLink object to open this dialog
	* 
	* @param HTMLComponent|array()|string $name the name of the link. this can also be a HTMLIcon or other HTMLComponents
	*/
	public function getHTMLLink($name = ""){
		$link = new HTMLLink("#".$this->getElementId());
		$link->addContent($name);
		$link->addAttribute("role", "button");
		$link->addAttribute("data-toggle", "modal");
		return $link;
	}
	/**
	* Check if the dialog is active
	*
	* Check is done with the check for className hide
	* @return boolean true, if the dialog is shown, false if it is hidden
	*/
	public function isActive(){
		return !$this->isClassNameSet("hide");
	}
	/**
	* Set the default state of this dialog
	*
	* @param boolean false, hides the dialog. true shows the dialog
	*/
	public function setActive($active){
		if($active){
			$this->removeClassName("hide");
			$this->removeClassName("fade");		
		}else{
			$this->addClassName("hide");
			$this->addClassName("fade");	
		}
	}
	public function getDisplayName(){
		return $this->getElementId();
	}
}
?>