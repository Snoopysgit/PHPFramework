<?php
namespace phpframework\components;

class HTMLTable extends HTMLComponent{
	protected function getTagName(){
		return "table";
	}
}
class HTMLTableHead extends HTMLComponent{
	protected function getTagName(){
		return "thead";
	}
}
class HTMLTableBody extends HTMLComponent{
	protected function getTagName(){
		return "tbody";
	}
}
class HTMLTableRow extends HTMLComponent{
	protected function getTagName(){
		return "tr";
	}
}
class HTMLTableCell extends HTMLComponent{
	protected function getTagName(){
		return "td";
	}
}
class HTMLTableHeadCell extends HTMLComponent{
	protected function getTagName(){
		return "th";
	}
}
?>