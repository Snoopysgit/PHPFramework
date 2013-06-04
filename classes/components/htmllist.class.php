<?php
class HTMLList extends HTMLContainer{
	private $listItems;
	public function __construct(){
		parent::__construct();
		$this->setTag("ul");
		$this->listItems = array();
	}
	public function refreshHTML(){
		parent::refreshHTML();
	}
}
class HTMLListItem extends HTMLContainer{
	public function __construct(){
		parent::__construct();
		$this->setTag("li");
	}
	public function refreshHTML(){
		parent::refreshHTML();
	}
	public function setActive($active){
		if($active){
			$this->addClassName("active");
		}else{
			$this->removeClassName("active");
		}
	}
}
?>