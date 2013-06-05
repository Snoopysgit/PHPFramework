<?php
namespace phpframework\orm;

class ComputerORM extends ORM{

	protected function __construct(){
		parent::__construct();
	}
	public static function getTableNameDeleteInsert(){
		return "computer";
	}
	public static function getTableNameView(){
		return "computer";
	}
	public static function getIdName(){
		return "idcomputer";
	}
	public static function getColumns(){
		return array(new Column("idcomputer","ID", ColumnType::ID),
						new Column("computername","Computername",ColumnType::TEXT), 
						new Column("typ","Typ",ColumnType::TEXT),
						new Column("os","Betriebssystem",ColumnType::TEXT));
	}
	public static function getViewAccessRight(){
		return "";
	}
	public static function getEditAccessRight(){
		return "";		
	}
}
?>