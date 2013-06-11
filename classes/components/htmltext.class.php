<?php
namespace phpframework\components;

/**
 * Represents an HTML Text
 * 
 * Provides Text specific methods
 * @author Christian Thommen
 */
class HTMLText extends HTMLContainer{
	protected function getTagName(){
		return "font";
	}
	/**
	 * Set the text content
	 * 
	 * @param string $text The text to set. This will remove any other content of this HTMLText tag. 
	 * If you want to have mixed content, use either a HTMLContainer
	 */
	public function setText($text){
		$this->removeAllContent();
		$this->addContent($text);
	}
	/**
	 * Get the text content
	 * 
	 * @return string The text of this tag
	 */
	public function getText(){
		return $this->getContent(0);
	}
}
?>