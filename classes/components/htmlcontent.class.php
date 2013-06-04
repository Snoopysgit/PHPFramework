<?php
class HTMLContent extends HTMLContainer{	
	public function __construct(){
       parent::__construct();
	}
	public function addContentIfNavigatorActive(HTMLComponent $HTMLComponent, NavigatorInterface $navigator){
		if($navigator->isActive()){
			parent::addContent($HTMLComponent);
		}
	}
}
?>