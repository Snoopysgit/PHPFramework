<?php
namespace phpframework\components;

/**
 * Interface IHTMLComponent
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
	 */
	function getHTML();
	/**
	 * Gets the inner HTML of this component
	 * 
	 * This is just the content between the start and the end tag, but without the tags. e.g: 
	 * <code>
	 * Hello world!
	 * </code>
	 */
	function getInnerHTML();
}
?>