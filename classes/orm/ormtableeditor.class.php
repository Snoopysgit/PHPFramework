<?php
namespace phpframework\orm;
use phpframework\components\HTMLContainer;
use phpframework\components\HTMLLabel;
use phpframework\components\HTMLInput;
use phpframework\components\HTMLSubmitButton;
use phpframework\components\HTMLTable;
use phpframework\components\HTMLTitle;
use phpframework\components\HTMLIcon;
use phpframework\components\HTMLText;
use phpframework\components\HTMLTableHead;
use phpframework\components\HTMLTableHeadCell;
use phpframework\components\HTMLTableRow;
use phpframework\components\HTMLTableBody;
use phpframework\components\HTMLTableCell;
use phpframework\modules\HTMLForm;
use phpframework\modules\HTMLDialog;
use phpframework\controlers\LoginControler;
use phpframework\controlers\MessageControler;
use phpframework\controlers\MessagePrinter;
require_once 'loginorm.class.php';

class ORMTableEditor extends HTMLContainer{
	private $columns;
	private $rowEditorClass = "phpframework\orm\ORMRowEditor";
	private $rowEditor;
	private $orm;
	private $table;
	private $newRowNr = 0;
	private $error;
	
	public function __construct(){
		parent::__construct();
		$this->error = new HTMLContainer();
		$this->addContent($this->error);
		$this->table = new HTMLTable();
		$this->rowEditor = array();
	}
	private function addDialogEditor($orm, $id){
		$form = new HTMLForm();
		$form->addClassName("form-horizontal");
		$dialog = new HTMLDialog();
		$form->addContent($dialog);
		$dialog->addContent(new HTMLTitle("Datensatz bearbeiten"), "head");
		$dialog->addContent(array($this->rowEditor[$id]->getSaveButton(),$this->rowEditor[$id]->getDeleteButton()), "foot");
		$dialog->addContent($this->rowEditor[$id], "body");
		$this->addContent($form);
		return $dialog;
	}
	private function initRowEditor($orm, $record){
		$orm = $this->orm;
		$classToCall = $this->rowEditorClass;
		$this->rowEditor[$record->getId()] = new $classToCall($orm, $record);
	}
	private function setHeader($columns){
		$thead = new HTMLTableHead();
		$headRow = new HTMLTableRow();
		$thead->addContent($headRow);
		$this->columns = $columns;
		foreach($this->columns as $column){
			$headRow->addContent(new HTMLTableHeadCell($column->getColumnDisplayName()));
		}
		if($this->isAllowedToEditRecords())
			$headRow->addContent(new HTMLTableHeadCell("Bearbeiten"));
		
		$this->table->addContent($thead);
	}
	private function setValues($values){
		$tbody = new HTMLTableBody();
		
		foreach($values as $row){
			$this->initRowEditor($this->orm, $row);
			if(!$this->rowEditor[$row->getId()]->isDeleted()){
				$contentRow = new HTMLTableRow();
				if($this->newRowNr == $row->getId())
					$contentRow->addClassName("success");
				if($this->rowEditor[$row->getId()]->isUpdateRequested()){
					if($this->rowEditor[$row->getId()]->isUpdated()){
						$contentRow->addClassName("success");
						$this->error->addContent(MessageControler::getMessage("Speichern erfolgreich", 
																"Datensatz erfolgreich angepasst!", 
																MessagePrinter::SuccessMessage));
					}else{
						$contentRow->addClassName("warning");	
						$this->error->addContent(MessageControler::getMessage("Datensatz nicht gespeichert", 
																"Dies kann passieren, wenn gespeichert wurde, obwohl keine Daten geändert wurden!", 
																MessagePrinter::WarningMessage));
					}
				}
				foreach($this->columns as $column){
					if($column->getColumnType() == ColumnType::PASSWORD){
						$contentRow->addContent(new HTMLTableCell("*****"));
					}else{
						$contentRow->addContent(new HTMLTableCell($row->getValue($column->getColumnName())));
					}
				}
				if($this->isAllowedToEditRecords()){
					$dialog = $this->addDialogEditor($this->orm, $row->getId());
					$link = $dialog->getHTMLLink("bearbeiten");
					$link->addContent(new HTMLIcon("icon-pencil"));
					$contentRow->addContent(new HTMLTableCell($link));
				}
				$tbody->addContent($contentRow);
			}else{
				$this->error->addContent(MessageControler::getMessage("Datensatz gelöscht", 
																"Datensatz erfolgreich gelöscht!", 
																MessagePrinter::SuccessMessage));
			}
		}
		$this->table->addContent($tbody);
	}
	public function setRowEditorClass($rowEditor){
		if(class_exists($rowEditor)){
			$this->rowEditorClass = $rowEditor;
		}
	}
	public function setORM($orm){
		$this->orm = $orm;
		if($this->isAllowedToEditRecords()){
			$this->initRowEditor($orm, $orm::newRow());
			$dialog = $this->addDialogEditor($this->orm, 0);
			$link = $dialog->getHTMLLink("bearbeiten");
			$link->addClassName("btn");
			$link->addContent(array(new HTMLIcon("icon-plus"),new HTMLText("Neu")));
			$this->addContent($link);
			if($this->rowEditor[0]->isUpdateRequested()){
				if($this->rowEditor[0]->isUpdated()){
					$this->error->addContent(MessageControler::getMessage("Hinzufügen erfolgreich", 
															"Datensatz erfolgreich erstellt!", 
															MessagePrinter::SuccessMessage));
					$this->newRowNr = $this->rowEditor[0]->getRecord()->getId();
				}else{
					$this->error->addContent(MessageControler::getMessage("Hinzufügen war nicht erfolgreich", 
															"Bitte den Vorgang wiederholen!", 
															MessagePrinter::ErrorMessage));
				}
			}
		}
		if($this->isAllowedToViewRecords()){
			$ormTable = $orm::getAll();
			$this->setHeader($orm::getColumns());
			$this->setValues($ormTable);
		}else{
			$this->error->addContent(MessageControler::getMessage("Nicht berechtigt", 
															"Sie sind nicht berechtigt diese Daten zu sehen", 
															MessagePrinter::ErrorMessage));
		}
		$this->addContent($this->table);
	}
	private function isAllowedToViewRecords(){
		$orm = $this->orm;
		return LoginControler::singleton()->hasAccessRight($orm::getViewAccessRight());
	}
	private function isAllowedToEditRecords(){
		$orm = $this->orm;
		return LoginControler::singleton()->hasAccessRight($orm::getEditAccessRight());
	}
}
class ORMRowEditor extends HTMLContainer{
	private $record = null;
	private $orm;
	private $editDisabled;
	private $fields;
	private $deleted;
	private $updated;
	private $deleteButton;
	private $saveButton;
	
	public function __construct($orm, $record = null, $editDisabled = false){
		parent::__construct();
		if($record != null){
			$orm = get_class($record);
		}else{
			$orm = $orm;
		}
		$this->orm = $orm;
		$this->deleted = false;
		$this->updated = false;
		$this->editDisabled = $editDisabled;
		$this->initComponents();
		$this->setRecord($record);
		$this->checkUpdateDelete();
	}
	private function checkUpdateDelete(){
		if($this->isUpdateRequested() && $this->isAllowedToEditRecords()){
			$this->save();
		}elseif($this->isDeleteRequested()&& $this->isAllowedToEditRecords()){
			$this->delete();
		}
	}
	public function setRecord($record){
		if($record instanceof ORMInterface && $record != null){
			$this->record = $record;
			$this->setFieldValues();
		}
	}
	public function getRecord(){
		return $this->record;
	}
	private function initComponents(){
		$this->initEditFields();
		$this->initDeleteButton();
		$this->initSaveButton();
	}
	protected function initEditFields(){
		$orm = $this->orm;
		foreach($orm::getColumns() as $column){
			if($column->getColumnType() != ColumnType::ID){
				if($column->getColumnType()== ColumnType::PASSWORD){
					$value = "*****";
					$this->addContent($this->getLabeledPassword($column->getColumnDisplayName(),$column->getColumnName(),"", $this->editDisabled));
				}else{
					$colName = $column->getColumnName();
					$this->addContent($this->getLabeledInput($column->getColumnDisplayName(),$column->getColumnName(),"", $this->editDisabled));			
				}
			}
		}
	}
	private function initDeleteButton(){
		$this->deleteButton = new HTMLSubmitButton("Löschen");
	}
	private function initSaveButton(){
		$this->saveButton = new HTMLSubmitButton("Speichern");
	}
	protected function setFieldValues(){
		$orm = $this->orm;
		foreach($orm::getColumns() as $column){
			if($column->getColumnType() != ColumnType::ID){
				if($column->getColumnType()==ColumnType::PASSWORD){
					$value = "*****";
				}else{
					$value = $this->record->getValue($column->getColumnName());		
				}
				$this->fields[$column->getColumnName()]->setValue($value);
			}
		}
	}
	private function getLabeledInput($label, $valueName, $value = "", $disabled = true){
		$controlGroup = new HTMLContainer();
		$controlGroup->addClassName("control-group");
		$controls = new HTMLContainer();
		$controls->addClassName("controls");
		
		$label = new HTMLLabel($label.": ");
		$label->addClassName("control-label");
		$field = new HTMLInput($valueName);
		$field->setDisabled($disabled);
		$field->setValue($value);
		$field->addClassName("input-block-level");
		$this->fields[$valueName] = $field;
		
		$controls->addContent($field);
		$controlGroup->addContent($label);
		$controlGroup->addContent($controls);
		return $controlGroup;
	}
	private function getLabeledPassword($label, $valueName, $value = "", $disabled = true){
		$controlGroup = new HTMLContainer();
		$controlGroup->addClassName("control-group");
		$controls = new HTMLContainer();
		$controls->addClassName("controls");
		
		$label = new HTMLLabel($label.": ");
		$label->addClassName("control-label");
		$field = new HTMLInput($valueName);
		$field->setDisabled($disabled);
		$field->setValue($value);
		$field->setType("password");
		$field->addClassName("input-medium");
		$this->fields[$valueName] = $field;
		if(!$disabled){
			$field2 = new HTMLInput($valueName."-Check");
			$this->fields[$valueName."-Check"] = $field2;
			$field2->setDisabled($disabled);
			$field2->setValue("*****");
			$field2->setType("password");
			$field2->addClassName("input-medium");
			$controls->addContent($field2);
		}
		$controls->addContent($field);
		$controlGroup->addContent($label);
		$controlGroup->addContent($controls);
		return $controlGroup;
	}
	public function getSaveButton(){
		return $this->saveButton;
	}
	protected function delete(){
		if($this->record->deleteFromDB()){
			$this->setDeleted(true);
			return true;
		}
		return false;
	}
	protected function save(){
		foreach($this->fields as $field){
			$fieldname = $field->getName();
			if($field->getType() != "password" or ($field->getValue() != "*****" and $fields[$fieldname."-Check"]->getValue() == $field->getValue())){
				$this->record->$fieldname = $field->getValue();
			}
		}
		$this->record->saveToDB();
		$this->setUpdated(true);
		return true;
	}
	protected function setUpdated($updated){
		$this->updated = $updated;
	}
	protected function setDeleted($deleted){
		$this->deleted = $deleted;
	}
	public function getDeleteButton(){
		return $this->deleteButton;
	}
	public function isDeleted(){
		return $this->deleted;
	}
	public function isUpdated(){
		return $this->updated;
	}
	public function isUpdateRequested(){
		return $this->saveButton->isActive();
	}
	public function isDeleteRequested(){
		return $this->deleteButton->isActive();
	}
	public function isRecordSet(){
		return $this->record != null;
	}
	public function isEditDisabled(){
		return $this->editDisabled;
	}
	private function isAllowedToEditRecords(){
		$orm = $this->orm;
		return LoginControler::singleton()->hasAccessRight($orm::getEditAccessRight());
	}
}

?>