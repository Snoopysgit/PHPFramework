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
	function getHTML();
	function getInnerHTML();
	function __toString();
	function setTag($tagName);
	function getTag();
	function getElementId();
	function addClassName($className);
	function removeClassName($className);
	function isClassNameSet($className);
	function addAttribute($attribute, $value);
	function getAttribute($attribute);
	function removeAttribute($attribute);
	function addContent($HTMLComponent);
	function removeContent(HTMLComponent $HTMLComponent);
	function getContent($elementId);
	function removeAllContent();
}
?>