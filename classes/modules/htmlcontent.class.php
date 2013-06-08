<?php
namespace phpframework\modules;
use phpframework\controlers\NavigatorInterface;
use phpframework\components\HTMLContainer;

class HTMLContent extends HTMLContainer{
	public function addContentIfNavigatorActive($HTMLComponent, NavigatorInterface $navigator){
		if($navigator->isActive()){
			parent::addContent($HTMLComponent);
		}
	}
}
?>