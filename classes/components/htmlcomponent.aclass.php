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
	/**
	* classNames contained in this tag
	*/
	private $classes = array();
	/**
	* attributes contained in this tag
	*/
	private $attributes = array();
	/**
	* holds the tagname, defaults to div
	*/
	private $tag = "";	
	/**
	* holds all content for this tag. 
	* This can be other HTMLComponents or Objects which implements the magic method __toString()
	*/
	private $content = array();
	/**
	* static counter for tag ID generation. Holds one counter per class
	*/
	private static $objId = array();
	
	/**
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
	/**
	* Sets the elementId
	* @param string $elementId a string for the id attribute of this component
	*/
	private function setElementId($elementId){
		$this->addAttribute("id", $elementId);
	}
	/**
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
	/**
	* Gets the end tag of this component
	*
	* @return string the end tag
	*/
	private function getEndTag(){
		return "</".$this->getTag().">\n";
	}
	/***
	* Gets the HTML of this component
	* 
	* This includes the content between the start and the end tag. e.g: 
	* <code>
	* &lt;div&gt;Hello world!&lt;/div&gt;
	* </code>
	* @return a string containing this tag including all the tags. This could be the whole page
	*/
	public function getHTML(){
		$HTML = $this->getStartTag();
		$HTML .= $this->getInnerHTML();
		$HTML .= $this->getEndTag();
		return $HTML;
	}
	/**
	* Gets the inner HTML of this component
	*
	* Gets the html output of this tag, without the start and end tag of this component
	* (This can be used for ajax purposes, where you want to fill the tag after page load)
	*
	* <code>
	* Hello world!
	* </code>
	* @return a string containing all subcomponents of this component, without the start and end tag of this component
	*/
	public function getInnerHTML(){
		$contentString = '';
		foreach($this->content as $content){
			$contentString .= $content."\n";
		}
		return $contentString;
	}
	/**
	* Gets the html output of this tag. Including all subtags. (Same as getHTML())
	*
	* @return a string containing this tag including all the tags. This could be the whole page
	*/
	public function __toString(){
		return $this->getHTML();
	}
	/**
	* Override the default tag set by the specific class
	*
	* @param string $tagName a string for the tagName(Overrides the default tagname of the specific class)
	*/
	public function setTag($tagName){
		$this->tag = $tagName;
	}
	/**
	* Gets tag tagName of this component
	* @return string tagName
	*/
	public function getTag(){
		if($this->tag == ""){
			return $this->getTagName();
		}else{
			return $this->tag;
		}
	}
	/**
	* Gets the elementId of this component. This is the Attribute named "id"
	*
	* @return a string containing the id of this component
	*/
	public function getElementId(){
		return $this->getAttribute("id");
	}
	/**
	* Adds a new CSS Class name to this component. It will automaticly be included in the class list of this component.
	*
	* @param string $className a classname to be included or multiple classnames seperated by a space
	*/
	public function addClassName($className){
		$classNames = explode(" ", $className);
		foreach($classNames as $name){
			$this->classes[$name] = $name;
		}
	}
	/**
	* Removes one or multiple CSS class names from this component( if they're present)
	*
	* @param string $className a classname to be excluded or multiple classnames seperated by a space
	*/
	public function removeClassName($className){
		$classNames = explode($className);
		foreach($classNames as $name){
			unset($this->classes[$name]);
		}
	}
	/**
	* Checks if a CSS className is already set for this component
	*
	* @param string $className a classname to be excluded or multiple classnames seperated by a space
	* @return boolean true if the className is set, fals if not
	*/
	public function isClassNameSet($className){
		return isset($this->classes[$className]);
	}
	/**
	* Adds a new attribute to this component. It will automaticly be included in the class list of this component.
	*
	* @param string $attribute an attributename
	* @param string $value the value of this attribute
	*/
	public function addAttribute($attribute, $value){
		$this->attributes[$attribute] = $value;
	}
	/**
	* Get's the current value of an attribute. 
	*
	* @param string $attribute an attributename to get the value of
	* @return string value of this attribute or null if it is not set at all
	*/
	public function getAttribute($attribute){
		return $this->attributes[$attribute];
	}
	/**
	* Removes an attribute of this component( if it's present)
	*
	* @param string $attribute an attribute to be excluded
	*/
	public function removeAttribute($attribute){
		unset($this->attributes[$attribute]);
	}
	/**
	* Adds content to this component. 
	* The content can be other HTMLComponents or classes which implements the magic method __toString()
	* To add multiple content at once you can also wrap multiple content objects within an array()
	*
	* @param string|HTMLComponent|array() $HTMLComponent single or multiple content objects to add
	* important: just HTMLComponents can be removed after they have been added with addContent.
	*/
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
	/**
	* Removes a HTMLComponent from this component. 
	*
	* @param HTMLComponent $HTMLComponent a HTMLComponent to remove
	*/
	public function removeContent(HTMLComponent $HTMLComponent){
		print "a";
		unset($this->content[$HTMLComponent->getElementId()]);
	}
	/**
	* Get's the HTMLComponent if it is contained within this component 
	*
	* @param string $elementId the elementId of a HTMLComponent to get
	* @return HTMLComponent|null the HTMLComponent if it is contained, or null if not
	*/
	public function getContent($elementId){
		return $this->content[$key];
	}
	/**
	* Removes all content elements of this component. After this, this component will just return start tag and end tag
	*
	*/
	public function removeAllContent(){
		$this->content = array();
	}
	/**
	* Get's the tagName of this component. Each specific implementation of this class must implement this function.
	* sample: return "div"; or return "font";
	* @param string $elementId the elementId of a HTMLComponent to get
	* @return string it mus return a string containing just alphabetic symbols a-z/A-Z
	*/
	protected abstract function getTagName();
}
?>