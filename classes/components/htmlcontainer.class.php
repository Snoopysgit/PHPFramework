<?php
class HTMLContainer extends HTMLComponent{	
	private $content = array();
	
	public function __construct($content = ""){
		parent::__construct();
		$this->addContent($content);
	}
	public function refreshHTML(){
		$containerContent = '';
		foreach($this->content as $content){
			if(is_a($content, "HTMLComponent")){
				$containerContent .= $content->getHTML()."\n";
			}else{
				$containerContent .= $content."\n";
			}
		}
		$this->setInnerHTML($containerContent);
	}
	public function addContent($HTMLComponent){
		if(is_array($HTMLComponent)){
			foreach($HTMLComponent as $value){
				$this->addContent($value);
			}
		}else{
			if(is_a($HTMLComponent, "HTMLComponent")){
				$this->content[$HTMLComponent->getElementId()] = $HTMLComponent;
			}elseif($HTMLComponent != ""){
				array_push($this->content, $HTMLComponent);
			}
		}
	}
	public function removeContent(HTMLComponent $HTMLComponent){
		unset($this->content[$HTMLComponent->getElementId()]);
	}
}
?>