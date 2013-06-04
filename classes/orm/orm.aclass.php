<?php
abstract class ORM implements ORMInterface{	
	protected function __construct(){
		$classname = get_called_class();
		$columns = $classname::getColumns();
		foreach($columns as $column){
			$colName = $column->getColumnName();
			$colType = $column->getColumnType();
			if(!property_exists($this, $colName)){
				switch($colType){
					case ColumnType::ID:
					case ColumnType::FK:
					case ColumnType::NUMBER:
						$this->$colName = 0;
						break;
					case ColumnType::TEXT:
					case ColumnType::PASSWORD:
						$this->$colName = "";
						break;
					default:
						$this->$colName = "";
				}
			}
		}
	}
    public function __set($name, $value){
        $this->$name = $value;
    }
    public function __get($name){
		if(isset($this->$key)){
			return $this->$key;
		}else{
			throw new Exception('ORM getValue called with unknown key: '.$key);
		}
    }	
	public static function getById($id){
		$classname = get_called_class();
		$params[$classname::getIdName()] = $id;
		return  self::getFromDatabase($params)[$id];
	}
	public static function NewRow(){
		$classname = get_called_class();
		$newRow = new $classname();
		return $newRow;
	}
	public static function getAll(){
		return self::getFromDatabase();
	}
	public static function getSubset($params, $ordering = ""){
		return self::getFromDatabase($params, $ordering);
	}
	private static function getFromDatabase($params = array(), $ordering = ""){
		$result = DatabaseControler::singleton()->select(self::createSelect().self::createWhere($params));
		$classname = get_called_class();
		if($ordering == ""){
			$ordering = $classname::getIdName();
		}
		if($result){
			return $result->getObjects($classname, $ordering);
		}else{
			return null;
		}
	}
	private static function createSelect(){
		$classname = get_called_class();
		$columns = "`".implode("`, `", $classname::getColumnNames())."`";
		return $select = "SELECT ".DatabaseControler::singleton()->sanitize($columns." FROM ".DatabaseControler::singleton()->sanitize($classname::getTableNameView()));
	}
	private static function createWhere($params){
		$where = "";
		if(count($params)>0){
			$where = " where";
			$first = true;
			foreach($params as $key => $value){
				if(!$first){
					$where .= " and";
				}
				if(is_numeric($value)){
					$where .= " ".DatabaseControler::singleton()->sanitize("`".$key."`")."=".DatabaseControler::singleton()->sanitize($value)."";		
				}else{
					$where .= " ".DatabaseControler::singleton()->sanitize("`".$key."`")."='".DatabaseControler::singleton()->sanitize($value)."'";
				}
				
				$first = false;
			}
		}
		return $where;
	}
	public static function getColumnNames(){
		$classname = get_called_class();
		$values = array();
		foreach($classname::getColumns() as $column){
			array_push($values, $column->getColumnName());
		}
		return $values;
	}
	public static function getColumnDisplayNames(){
		$classname = get_called_class();
		$values = array();
		foreach($classname::getColumns() as $column){
			array_push($values, $column->getColumnDisplayName());
		}
		return $values;
	}
	public static function getColumnColumnTypes(){
		$classname = get_called_class();
		$values = array();
		foreach($classname::getColumns() as $column){
			array_push($values, $column->getColumnType());
		}
		return $values;
	}
	private function createUpdate(){
		$classname = get_called_class();
		$statement = "UPDATE ".DatabaseControler::singleton()->sanitize($classname::getTableNameDeleteInsert())." SET ";
		$columnToValue = array();
		foreach($classname::getColumns() as $column){
			if($column->getColumnType() != "id"){
				array_push($columnToValue, "`".$column->getColumnName()."`='".DatabaseControler::singleton()->sanitize($this->getValue($column->getColumnName()))."'");
			}
		}
		$statement .= implode(",",$columnToValue);

		$params[$classname::getIdName()] = $this->getValue($classname::getIdName());
		$statement .= " ".self::createWhere($params);
		return $statement;
	}
	private function createInsert(){
		$classname = get_called_class();
		$statement = "INSERT INTO ".DatabaseControler::singleton()->sanitize($classname::getTableNameDeleteInsert())." (";
		$columns = array();
		$values = array();
		foreach($classname::getColumns() as $column){
			if($column->isInsertRelevant()){
				array_push($columns, "`".$column->getColumnName()."`");
				array_push($values, "'".DatabaseControler::singleton()->sanitize($this->getValue($column->getColumnName()))."'");
			}
		}
		$statement .= implode(",",$columns);
		$statement .= ") VALUES (";
		$statement .= implode(",",$values);
		$statement .= ")";
		return $statement;
	}
	private function createDelete(){
		$classname = get_called_class();
		$statement = "DELETE FROM ".DatabaseControler::singleton()->sanitize($classname::getTableNameDeleteInsert())." ";
		$classname = get_called_class();
		$params[$classname::getIdName()] = $this->getValue($classname::getIdName());
		$statement .= " ".self::createWhere($params);
		return $statement;
	}
	public function getValue($key){
		if(isset($this->$key)){
			return $this->$key;
		}else{
			throw new Exception('ORM getValue called with unknown key: '.$key);
		}
	}
	public function getId(){
		return $this->getValue($this->getIdName());
	}
	public function saveToDB(){
		$classname = get_called_class();
		$idname = $classname::getIdName();
		if($this->$idname > 0){ //bestehenden eintrag speichern
			if(DatabaseControler::singleton()->modify($this->createUpdate()) >0){
				return true;
			}else{
				return false;
			}
		}else{ // neuen eintrag erestellen
			if(DatabaseControler::singleton()->modify($this->createInsert()) >0){
				$this->$idname = DatabaseControler::singleton()->getInsertedId();
				return true;
			}else{
				return false;
			}
		}
	}
	public function deleteFromDB(){
		if(DatabaseControler::singleton()->modify($this->createDelete())>0){
			return true;
		}else{
			return false;
		}
	}
}
interface ORMInterface{
	public static function getById($id);
	public static function getAll();
	public static function getSubset($params, $ordering = "");
	
	public static function getTableNameView();
	public static function getTableNameDeleteInsert();
	public static function getIdName();
	public static function getColumns();
	public static function getColumnNames();
	public static function getColumnDisplayNames();
	public static function getColumnColumnTypes();
	public static function getViewAccessRight();
	public static function getEditAccessRight();
	
	public function getValue($key);
	public function getId();
	public function saveToDB();
	public function deleteFromDB();
}

class Column{
	private $columnName;
	private $columnDisplayName;
	private $columnType;
	private $insertRelevant;
	
	public function __construct($columnName, $columnDisplayName, $columnType, $insertRelevant = true){
		$this->columnName = $columnName;
		$this->columnDisplayName = $columnDisplayName;
		$this->columnType = $columnType;
		$this->insertRelevant = $insertRelevant;
		if($this->columnType == ColumnType::ID){
			$this->insertRelevant = false;
		}
	}
	public function getColumnName(){
		return $this->columnName;
	}
	public function getColumnDisplayName(){
		return $this->columnDisplayName;
	}
	public function getColumnType(){
		return $this->columnType;
	}
	public function isInsertRelevant(){
		return $this->insertRelevant;
	}
}
class ColumnType{
	const ID = 0;
	const FK = 1;
	const NUMBER = 2;
	const TEXT = 3;
	const PASSWORD = 4;
}
class ForeignKeyConstruct{
	private $table1;
	private $table2;
	private $table3;
	public function __construct(){
		
	}
	
}
?>