<?php
/**
 * Interface IHTMLComponent
 * Interface for all HTMLComponents. A HTML component is basicly a tag with content. Therefore the interface provides methods to get these tag information.
 * A Tag can be {<a></a> or <div></div>}
 * @author Christian Thommen
 */
interface IHTMLComponent{
	/**
	 * Gets the HTML of this component
	 * 
	 * This includes the content between the start and the end tag. e.g: 
	 * {<div>Hello world!</div>}
	 */
	function getHTML();
	/**
	 * Gets the inner HTML of this component
	 * 
	 * This is just the content between the start and the end tag, but without the tags. e.g: 
	 * {Hello world!}
	 */
	function getInnerHTML();
}
?>