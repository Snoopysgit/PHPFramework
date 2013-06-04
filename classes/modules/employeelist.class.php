<?php
class EmployeeList extends ORMTableEditor{
	public function __construct(){
		parent::__construct();
		$this->setRowEditorClass("EmployeeDataSheet");
		$this->setORM("LoginORM");
	}
	public function refreshHTML(){
		parent::refreshHTML();
	}
} 

?>