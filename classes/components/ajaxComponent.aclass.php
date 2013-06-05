<?php
namespace phpframework\components;

abstract class AjaxComponent extends HTMLComponent implements AjaxComponentInterface{
	private $loadDeferred;
	public function __construct($loadDeferred = false){
		parent::__construct();
		$this->addClassName("AjaxComponent");
		$this->addAttribute("contentType", $this->getType());
		$this->loadDeferred = $loadDeferred;
		if($this->loadDeferred){
			$this->addAttribute("loaded","false");
		}else{
			$this->addAttribute("loaded","true");
		}
	}
	public function getHTML(){
		if($this->loadDeferred){
			return $this->getHTMLContainer();
		}else{
			return parent::getHTML();
		}
	}
	public function getHTMLContainer(){
		return $this->getStartTag().$this->getEndTag();
	}
}
?>