<?php
class PersonAccessRightORM extends ORM{
	protected function __construct(){
		parent::__construct();
	}
	public static function getTableNameDeleteInsert(){
		return "accessrighttoperson";
	}
	public static function getTableNameView(){
		return "vPersonAccessRight";
	}
	public static function getIdName(){
		return "idaccessrighttoperson";
	}
	public static function getColumns(){
		return array(new Column("idaccessrighttoperson","ID", ColumnType::ID),
						new Column("idperson","FK",ColumnType::FK), 
						new Column("idaccessright","FK",ColumnType::FK),
						new Column("functionname","Funktionsname",ColumnType::TEXT, false));
	}
	public static function getViewAccessRight(){
		return "";
	}
	public static function getEditAccessRight(){
		return "";
	}
}
?>