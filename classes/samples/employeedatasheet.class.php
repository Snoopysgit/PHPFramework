<?php
namespace phpframework\samples;
use phpframework\orm\ormroweditor;
use phpframework\orm\accessrightorm;
use phpframework\orm\personaccessrightorm;
use phpframework\components\htmltitle;
use phpframework\components\htmllabel;
use phpframework\components\htmlcheckbox;

class EmployeeDataSheet extends ORMRowEditor{
	private $possibleAccessRights = array();
	private $currentAccessRights = array();
	public function __construct($orm = "", $record = null, $editDisabled = false){
		if($orm == ""){
			$orm = "phpframework\orm\LoginORM";
		}
		parent::__construct($orm, $record, $editDisabled);
	}
	protected function initEditFields(){
		parent::initEditFields();
		$this->initAccessRights();
	}
	protected function setFieldValues(){
		parent::setFieldValues();
		$this->setAccessRightsValues();
	}
	protected function save(){
		if(parent::save()){
			foreach($this->possibleAccessRights as $editBox){
				if($editBox->isChecked()){
						print "id=".$editBox->getValue();
					if(!isset($this->currentAccessRights[$editBox->GetValue()])){
						// neuen eintrag erstellen
						$newAccessRight = PersonAccessRightORM::newRow();
						$newAccessRight->idperson = $this->getRecord()->getId();
						$newAccessRight->idaccessright = $editBox->getValue();
						$newAccessRight->saveToDB();
						$this->currentAccessRights[$newAccessRight->idaccessright] = $newAccessRight;
						$this->possibleAccessRights[$newAccessRight->idaccessright]->setChecked(true);
					}
				}else{
					if(isset($this->currentAccessRights[$editBox->GetValue()])){
						// bestehenden Eintrag löschen
						$record = $this->currentAccessRights[$editBox->GetValue()];
						$record->deleteFromDB();
						$this->possibleAccessRights[$editBox->GetValue()]->setChecked(false);
						unset($this->currentAccessRights[$editBox->GetValue()]);
					}
				}
			}
		}
	}
	protected function delete(){
		if($this->currentAccessRights != null){
			foreach($this->currentAccessRights as $accessRight){
				$accessRight->deleteFromDB();
			}
		}
		parent::delete();
	}
	private function setAccessRightsValues(){
		$params["idperson"] = $this->getRecord()->getId();
		$this->currentAccessRights = PersonAccessRightORM::getSubset($params, "idaccessright");
		foreach($this->possibleAccessRights as $rightBox){
			if(isset($this->currentAccessRights[$rightBox->getValue()])){
				$rightBox->setChecked(true);
			}else{
				$rightBox->setChecked(false);
			}
		}
	}
	private function initAccessRights(){
		$accessRights = AccessRightORM::getAll();
		$this->addContent(new HTMLTitle("Benutzerrechte"));
		foreach($accessRights as $accessRight){
			$rightLabel = new HTMLLabel($accessRight->getValue("displayname"));
			$rightBox = new HTMLCheckbox();
			$rightBox->setValue($accessRight->getId());
			if($this->isEditDisabled())
				$rightBox->setDisabled(true);
			$this->possibleAccessRights[$rightBox->getValue()] = $rightBox;
			$rightLabel->addContent($rightBox);
			$this->addContent($rightLabel);
		}
	}
}
?>