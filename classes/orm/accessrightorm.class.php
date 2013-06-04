<?php
class AccessRightORM extends ORM{

	protected function __construct(){
		parent::__construct();
	}
	public static function getTableNameDeleteInsert(){
		return "vaccessright";
	}
	public static function getTableNameView(){
		return "vaccessright";
	}
	public static function getIdName(){
		return "idaccessright";
	}
	public static function getColumns(){
		return array(new Column("idaccessright","ID", ColumnType::ID),
						new Column("displayname","Anzeigename",ColumnType::TEXT), 
						new Column("functionname","Interner Name",ColumnType::TEXT));
	}
	public static function getViewAccessRight(){
		return "";
	}
	public static function getEditAccessRight(){
		return "";
	}
}
?>