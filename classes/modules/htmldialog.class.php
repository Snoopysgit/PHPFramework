<?php
namespace phpframework\modules;
use phpframework\components\htmlcontainer;
use phpframework\components\htmlbutton;
use phpframework\components\htmllink;
use phpframework\controlers\navigatorinterface;

class HTMLDialog extends HTMLContainer implements NavigatorInterface{	
	private $head;
	private $body;
	private $foot;
	private $active;
	
	public function __construct($content = ""){
		parent::__construct();
		$this->initComponents($content);
		$this->addClassName("modal");
		$this->setActive(false);
		$this->addAttribute("role", "dialog");
		$this->addAttribute("aria-hidden", "true");
	}
	private function initComponents($content){
		$this->initHead();
		$this->initBody($content);
		$this->initFoot();
	}
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
	private function initBody($content){
		$this->body = new HTMLContainer($content);
		$this->body->addClassName("modal-body");
		$this->addContent($this->body);
	}
	private function initFoot(){
		$this->foot = new HTMLContainer();	
		$this->foot->addClassName("modal-footer");
		$this->addContent($this->foot);
	}
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
	public function getHTMLLink($name){
		$link = new HTMLLink("#".$this->getElementId());
		$link->addAttribute("role", "button");
		$link->addAttribute("data-toggle", "modal");
		return $link;
	}
	public function isActive(){
		return !$this->isClassNameSet("hide");
	}
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