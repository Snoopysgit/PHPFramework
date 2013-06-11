<?php
namespace phpframework\components;

/**
 * Represents an HTML Container
 * 
 * This class can be used to do layout stuff. It represents a div tag without special attributes or classNames set by default
 * @author Christian Thommen
 */
class HTMLContainer extends HTMLComponent{
	protected function getTagName(){
		return "div";
	}
}
?>