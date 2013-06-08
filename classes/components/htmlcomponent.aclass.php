<?php
namespace phpframework\components;

/**
 * Base class for all HTMLComponents
 * 
 * This abstract class implements the HTMLComponentInterface and provides basic features which every HTML tag can have
 * This includes an ID for each tag and the possibility to add/remove attributes or classnames to the tag
 * @author Christian Thommen
 */
abstract class HTMLComponent implements HTMLComponentInterface{
	/*
	* classNames contained in this tag
	*/
	private $classes = array();
	/*
	* attributes contained in this tag
	*/
	private $attributes = array();
	/*
	* holds the tagname, defaults to div
	*/
	private $tag = "";	
	/*
	* holds all content for this tag. 
	* This can be other HTMLComponents or Objects which implements the magic method __toString()
	*/
	private $content = array();
	/*
	* static counter for tag ID generation. Holds one counter per class
	*/
	private static $objId = array();
	
	/*
	* The constructor of a HTMLComponent initializes the component with a 
	* @param $content HTMLComponent or class which implements __toString or an array() of such objects 
	* @return a new instance of this class
	*/
	public function __construct($content = null){
		$classWithNamespace = str_replace('\\', '_', get_class($this));
		if(isset(self::$objId[$classWithNamespace])){
			self::$objId[$classWithNamespace]++;
		}else{
			self::$objId[$classWithNamespace] = 0;
		}
		$this->setElementId($classWithNamespace."_".self::$objId[$classWithNamespace]);
		$this->addContent($content);
	}
	/*
	* Sets the elementId
	* @param string $elementId a string for the id attribute of this component
	*/
	private function setElementId($elementId){
		$this->addAttribute("id", $elementId);
	}
	/*
	* Gets the start tag of this component. This includes all attributes, classNames and the ID of this component.
	*
	* @return a string with the whole start tag
	*/
	private function getStartTag(){
		$startTag = "<".$this->getTag();
		
		foreach($this->attributes as $attributeKey => $attributeValue){
			$startTag .= " ";
			$startTag .= $attributeKey;
			$startTag .= "='";
			$startTag .= $attributeValue;
			$startTag .= "'";
		}
		if(count($this->classes)>0){
			$startTag .= " class='";
			foreach($this->classes as $class){
				$startTag .= $class;
				$startTag .= " ";
			}
			$startTag .= "'";
		}
		$startTag .= ">\n";
		return $startTag;
	}
	/*
	* Gets the end tag of this component
	*
	* @return string the end tag
	*/
	private function getEndTag(){
		return "</".$this->getTag().">\n";
	}
	public function getHTML(){
		$HTML = $this->getStartTag();
		$HTML .= $this->getInnerHTML();
		$HTML .= $this->getEndTag();
		return $HTML;
	}
	public function getInnerHTML(){
		$contentString = '';
		foreach($this->content as $content){
			$contentString .= $content."\n";
		}
		return $contentString;
	}
	public function __toString(){
		return $this->getHTML();
	}
	public function setTag($tagName){
		$this->tag = $tagName;
	}
	public function getTag(){
		if($this->tag == ""){
			return $this->getTagName();
		}else{
			return $this->tag;
		}
	}
	public function getElementId(){
		return $this->getAttribute("id");
	}
	public function addClassName($className){
		$classNames = explode(" ", $className);
		foreach($classNames as $name){
			$this->classes[$name] = $name;
		}
	}
	public function removeClassName($className){
		$classNames = explode($className);
		foreach($classNames as $name){
			unset($this->classes[$name]);
		}
	}
	public function isClassNameSet($className){
		return isset($this->classes[$className]);
	}
	public function addAttribute($attribute, $value){
		$this->attributes[$attribute] = $value;
	}
	public function getAttribute($attribute){
		return $this->attributes[$attribute];
	}
	public function removeAttribute($attribute){
		unset($this->attributes[$attribute]);
	}
	public function addContent($HTMLComponent){
		if($HTMLComponent != null){
			if(is_array($HTMLComponent)){
				foreach($HTMLComponent as $value){
					$this->addContent($value);
				}
			}else{
				if(is_a($HTMLComponent, "phpframework\components\HTMLComponent")){
					$this->content[$HTMLComponent->getElementId()] = $HTMLComponent;
				}elseif($HTMLComponent != ""){
					$this->content[] = $HTMLComponent;
				}
			}
		}
	}
	public function removeContent(HTMLComponent $HTMLComponent){
		print "a";
		unset($this->content[$HTMLComponent->getElementId()]);
	}
	public function getContent($elementId){
		return $this->content[$key];
	}
	public function removeAllContent(){
		$this->content = array();
	}
	/*
	* Get's the tagName of this component. Each specific implementation of this class must implement this function.
	* sample: return "div"; or return "font";
	* @param string $elementId the elementId of a HTMLComponent to get
	* @return string it mus return a string containing just alphabetic symbols a-z/A-Z
	*/
	protected abstract function getTagName();
}
?>