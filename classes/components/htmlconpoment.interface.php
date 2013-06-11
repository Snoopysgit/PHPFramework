<?php
namespace phpframework\components;

/**
 * Base for all HTMLComponents
 * 
 * Interface for all HTMLComponents. A HTML component is basicly a tag with content. Therefore the interface provides methods to get these tag information.
 * A Tag can be e.g.:
 * <code>
 * &lt;a&gt;&lt;/a&gt;
 * &lt;div&gt;&lt;/div&gt;
 * </code>
 * @author Christian Thommen
 */
interface HTMLComponentInterface{
	/**
	* Gets the HTML of this component
	* 
	* This includes the content between the start and the end tag. e.g: 
	* <code>
	* &lt;div&gt;Hello world!&lt;/div&gt;
	* </code>
	* @return string containing this tag including all the tags. This could be the whole page
	*/
	function getHTML();
	/**
	* Gets the inner HTML of this component
	*
	* Gets the html output of this tag, without the start and end tag of this component
	* (This can be used for ajax purposes, where you want to fill the tag after page load)
	*
	* <code>
	* Hello world!
	* </code>
	* @return string containing all subcomponents of this component, without the start and end tag of this component
	*/
	function getInnerHTML();
	/**
	* Gets the html output of this tag. Including all subtags. (Same as getHTML())
	*
	* @return string containing this tag including all the tags. This could be the whole page
	*/
	function __toString();
	/**
	* Override the default tag set by the specific class
	*
	* @param string $tagName a string for the tagName(Overrides the default tagname of the specific class)
	*/
	function setTag($tagName);
	/**
	* Gets tag tagName of this component
	* @return string tagName
	*/
	function getTag();
	/**
	* Gets the elementId of this component. This is the Attribute named "id"
	*
	* @return string containing the id of this component
	*/
	function getElementId();
	/**
	* Adds a new CSS Class name to this component. It will automaticly be included in the class list of this component.
	*
	* @param string $className a classname to be included or multiple classnames seperated by a space
	*/
	function addClassName($className);
	/**
	* Removes one or multiple CSS class names from this component( if they're present)
	*
	* @param string $className a classname to be excluded or multiple classnames seperated by a space
	*/
	function removeClassName($className);
	/**
	* Checks if a CSS className is already set for this component
	*
	* @param string $className a classname to be excluded or multiple classnames seperated by a space
	* @return boolean true if the className is set, fals if not
	*/
	function isClassNameSet($className);
	/**
	* Adds a new attribute to this component. It will automaticly be included in the class list of this component.
	*
	* @param string $attribute an attributename
	* @param string $value the value of this attribute
	*/
	function addAttribute($attribute, $value);
	/**
	* Get's the current value of an attribute. 
	*
	* @param string $attribute an attributename to get the value of
	* @return string value of this attribute or null if it is not set at all
	*/
	function getAttribute($attribute);
	/**
	* Removes an attribute of this component( if it's present)
	*
	* @param string $attribute an attribute to be excluded
	*/
	function removeAttribute($attribute);
	/**
	* Adds content to this component. 
	* The content can be other HTMLComponents or classes which implements the magic method __toString()
	* To add multiple content at once you can also wrap multiple content objects within an array()
	*
	* @param string|HTMLComponent|array() $HTMLComponent single or multiple content objects to add
	* important: just HTMLComponents can be removed after they have been added with addContent.
	*/
	function addContent($HTMLComponent);
	/**
	* Removes a HTMLComponent from this component. 
	*
	* @param HTMLComponent $HTMLComponent a HTMLComponent to remove
	*/
	function removeContent(HTMLComponent $HTMLComponent);
	/**
	* Get's the HTMLComponent if it is contained within this component 
	*
	* @param string $elementId the elementId of a HTMLComponent to get
	* @return HTMLComponent|null the HTMLComponent if it is contained, or null if not
	*/
	function getContent($elementId);
	/**
	* Removes all content elements of this component. After this, this component will just return start tag and end tag
	*
	*/
	function removeAllContent();
}
?>