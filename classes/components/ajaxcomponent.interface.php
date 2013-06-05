<?php
namespace phpframework\components;
/*
Alle Komponenten/Module, welche dynamische geladen werden sollen, müssen dieses Interface implementieren.
Die Implementierende Klasse muss dafür sorgen, dass der Container der Komponente oder des Moduls das Feld Class mit AjaxContent ergänzt
*/
interface AjaxComponentInterface{
	public function getHTMLContainer();
	public function getInnerHTML();
}
?>