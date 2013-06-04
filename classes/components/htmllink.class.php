<?php
class HTMLLink extends HTMLText{
	private $link;
	public function __construct($link){
		parent::__construct("");
		$this->setTag("a");
		$this->setLink($link);
	}
	public function getLink(){
		return $this->link;
	}
	public function setLink($link){
		$this->link = $link;
		$this->addAttribute("href",$link);
	}
}
?>