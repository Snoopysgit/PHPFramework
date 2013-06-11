<?php
namespace phpframework\components;

/**
 * Represents an HTML Link
 * 
 * Provides link specific methods
 * @author Christian Thommen
 */
class HTMLLink extends HTMLText{
	protected function getTagName(){
		return "a";
	}
	/**
	 * Creates a new instance
	 * 
	 * @param string $link The link of this link tag
	 * @return HTMLLink object
	 */
	public function __construct($link){
		parent::__construct();
		$this->setLink($link);
	}
	/**
	 * Set the href attribute of this tag
	 * 
	 * @return string The href text of this link tag
	 */
	public function getLink(){
		return $this->getAttribute("href");
	}
	/**
	 * Get the href attribute of this tag
	 * 
	 * @param string $link The href text of this link tag
	 */
	public function setLink($link){
		$this->addAttribute("href",$link);
	}
}
?>