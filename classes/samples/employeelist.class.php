<?php
namespace phpframework\samples;
use phpframework\orm\ormtableeditor;

class EmployeeList extends ORMTableEditor{
	public function __construct(){
		parent::__construct();
		$this->setRowEditorClass("phpframework\samples\EmployeeDataSheet");
		$this->setORM("phpframework\orm\LoginORM");
	}
	public function refreshHTML(){
		parent::refreshHTML();
	}
} 

?>