<?php
class HTMLText extends HTMLContainer{
	private $text = "";
	
	public function __construct($text = ""){
       parent::__construct();
	   $this->setTag("font");
	   
	   $this->setText($text);
	}
	public function refreshHTML(){
		$this->addContent($this->getText());
		parent::refreshHTML();
	}
	
	public function setText($text){
		$this->text = $text;
	}
	public function getText(){
		if($this->text){
			return $this->text;
		}else{
			return "";
		}
	}
}
?>