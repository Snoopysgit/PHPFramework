<?php
class LoginORM extends ORM{

	protected function __construct(){
		parent::__construct();
	}
	public static function getTableNameDeleteInsert(){
		return "person";
	}
	public static function getTableNameView(){
		return "vperson";
	}
	public static function getIdName(){
		return "idperson";
	}
	public static function getColumns(){
		return array(new Column("idperson","ID", ColumnType::ID),
						new Column("firstname","Vorname",ColumnType::TEXT), 
						new Column("lastname","Nachname",ColumnType::TEXT), 
						new Column("username","Benutzername",ColumnType::TEXT),
						new Column("password","Passwort",ColumnType::PASSWORD));
	}
	public static function getViewAccessRight(){
		return "";
	}
	public static function getEditAccessRight(){
		return "";
	}
	public static function getReferencedTables(){
		return array("AccessRightORM", );
	}
}
?>