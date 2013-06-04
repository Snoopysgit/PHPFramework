<?php
/**
 * Interface IHTMLComponent
 * Interface for all HTMLComponents. A HTML component is basicly a tag with content. Therefore the interface provides methods to get these tag information.
 * A Tag can be <a></a> or <div></div>
 */
interface IHTMLComponent{
	
	function getHTML();
	function getInnerHTML();
}
?>