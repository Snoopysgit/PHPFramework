<?php
abstract class HTMLComponent implements IHTMLComponent{
	// className
	private $className;
	
	//element id, klasse und attribute der komponente
	private $elementId = "";
	private $classes = array();
	private $attributes = array();
	
	//html output
	private $HTML;
	private $innerHTML;
	private $tag = "div";
	private $startTag;
	private $endTag;
	
	// laufnummer für alle HTML objekte
	private static $objId = array();
	
	public function __construct(){
		$this->className = get_class($this);
		if(isset(self::$objId[$this->className])){
			self::$objId[$this->className]++;
		}else{
			self::$objId[$this->className] = 0;			
		}
		$this->setElementId($this->className."_".self::$objId[$this->className]);
	}
	public function getHTML(){
		$this->setHTML();			// setzt einen container um die html inhalte
		return $this->HTML;			// gibt html zurück
	}
	public function __toString(){
		return $this->getHTML();
	}
	public function getInnerHTML(){
		$this->refreshHTML();		// aktualisiert html inhalte
		return $this->innerHTML;		
	}
	public function getElementId(){
		return $this->elementId;
	}
	private function setElementId($elementId){
		$this->elementId = $elementId;
		$this->addAttribute("id", $elementId);
	}
	public function getClassName(){
		return $this->className;
	}
	private function setHTML(){
		$this->HTML .= $this->getStartTag();
		$this->HTML .= $this->getInnerHTML();
		$this->HTML .= $this->getEndTag();
	}
	protected function setInnerHTML($newInnerHTML){
		$this->innerHTML = $newInnerHTML;		
	}
	protected function addInnerHTML($newInnerHTML){
		$this->innerHTML .= $newInnerHTML;		
	}
	public function setTag($newTag){
		$this->tag = $newTag;
	}
	public function addClassName($className){
		$this->classes[$className] = $className;
	}
	public function removeClassName($className){
		unset($this->classes[$className]);
	}
	public function isClassNameSet($className){
		return isset($this->classes[$className]);
	}
	public function addAttribute($attribute, $value){
		$this->attributes[$attribute] = $value;
	}
	public function getAttribute($attribute){
		return $this->attributes[$attribute];
	}
	public function removeAttribute($attribute){
		unset($this->attributes[$attribute]);
	}
	public function getStartTag(){
		$this->setStartTag();
		return $this->startTag;
	}
	public function getEndTag(){
		$this->setEndTag();
		return $this->endTag;	
	}
	private function setStartTag(){
		$this->startTag = "<$this->tag";
		
		foreach($this->attributes as $attributeKey => $attributeValue){
			$this->startTag .= " ";
			$this->startTag .= $attributeKey;
			$this->startTag .= "='";
			$this->startTag .= $attributeValue;
			$this->startTag .= "'";
		}
		if(count($this->classes)>0){
			$this->startTag .= " class='";
			foreach($this->classes as $class){
				$this->startTag .= $class;
				$this->startTag .= " ";
			}
			$this->startTag .= "'";
		}
		$this->startTag .= ">\n";
	}
	private function setEndTag(){
		$this->endTag = "</$this->tag>\n";
	}
	/*
	refreshHTML aktualisiert den HTML Inhalt. Die Funktionsollte setInnerHTML aufrufen
	*/
	abstract function refreshHTML();
}
?>