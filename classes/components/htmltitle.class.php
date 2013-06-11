<?php
namespace phpframework\components;

/**
 * Represents an HTML Title
 * 
 * Provides title specific methods
 * @author Christian Thommen
 */
class HTMLTitle extends HTMLText{
	protected function getTagName(){
		return "h4";
	}
}
?>