<?php
namespace phpframework\samples;
use phpframework\orm\ORMTableEditor;

class EmployeeList extends ORMTableEditor{
	public function __construct(){
		parent::__construct();
		$this->setRowEditorClass("phpframework\samples\EmployeeDataSheet");
		$this->setORM("phpframework\orm\loginorm");
		$this->addClassName("table table-condensed table-striped");
	}
	public function refreshHTML(){
		parent::refreshHTML();
	}
} 

?>