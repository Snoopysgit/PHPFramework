<?php
/**
 * Interface IHTMLComponent
 * Interface for all HTMLComponents. A HTML component is basicly a tag with content. Therefore the interface provides methods to get these tag information.
 * A Tag can be:
 * <code><pre>
 * <a></a>
 * <div></div>
 * </pre></code>
 * @author Christian Thommen
 */
interface IHTMLComponent{
	/**
	 * Gets the HTML of this component
	 * 
	 * This includes the content between the start and the end tag. e.g: 
	 * <code><pre>
	 * <div>Hello world!</div>
	 * </pre></code>
	 */
	function getHTML();
	/**
	 * Gets the inner HTML of this component
	 * 
	 * This is just the content between the start and the end tag, but without the tags. e.g: 
	 * <code><pre>
	 * Hello world!
	 * </pre></code>
	 */
	function getInnerHTML();
}
?>