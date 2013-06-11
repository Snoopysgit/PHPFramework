<?php
namespace phpframework\components;

/**
 * Represents an HTML Table
 * 
 * Provides Table specific methods
 * @author Christian Thommen
 */
class HTMLTable extends HTMLComponent{
	protected function getTagName(){
		return "table";
	}
}
/**
 * Represents an HTML TableHead
 * 
 * Provides TableHead specific methods
 * @author Christian Thommen
 */
class HTMLTableHead extends HTMLComponent{
	protected function getTagName(){
		return "thead";
	}
}
/**
 * Represents an HTML TableBody
 * 
 * Provides TableBody specific methods
 * @author Christian Thommen
 */
class HTMLTableBody extends HTMLComponent{
	protected function getTagName(){
		return "tbody";
	}
}
/**
 * Represents an HTML TableRow
 * 
 * Provides TableRow specific methods
 * @author Christian Thommen
 */
class HTMLTableRow extends HTMLComponent{
	protected function getTagName(){
		return "tr";
	}
}
/**
 * Represents an HTML TableCell
 * 
 * Provides TableCell specific methods
 * @author Christian Thommen
 */
class HTMLTableCell extends HTMLComponent{
	protected function getTagName(){
		return "td";
	}
}
/**
 * Represents an HTML TableHeadCell
 * 
 * Provides TableHeadCell specific methods
 * @author Christian Thommen
 */
class HTMLTableHeadCell extends HTMLComponent{
	protected function getTagName(){
		return "th";
	}
}
?>