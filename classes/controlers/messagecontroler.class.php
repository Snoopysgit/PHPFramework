<?php
namespace phpframework\controlers;

class MessageControler extends Controler{
	private $printer;
	protected function __construct(){
		parent::__construct();
		$this->setPrinter(new DefaultMessagePrinter());
	}
    public static function handleException(Exception $e){
		MessageControler::singleton()->getPrinter()->printException($e);
    }
    public static function handleError($code, $msg, $file, $line){
		MessageControler::singleton()->getPrinter()->printError($code, $msg, $file, $line);
    }
	public function setPrinter(MessagePrinter $printer){
		$this->printer = $printer;
	}
	public function getPrinter(){
		return $this->printer;
	}
	public static function getMessage($titel, $msg, $type){
		return MessageControler::singleton()->getPrinter()->getMessage($titel, $msg, $type);
	}
}

interface MessagePrinter{
	const InformationMessage = 0;
	const SuccessMessage = 1;
	const ErrorMessage = 2;
	const WarningMessage = 3;
	
    public function printException(Exception $e);
	public function printError($titel, $message, $id, $color);
	public function getMessage($titel, $message, $type);
}

use phpframework\components\htmlcontainer;
use phpframework\components\htmlbutton;
use phpframework\components\htmltext;

class DefaultMessagePrinter implements MessagePrinter{
    public function printException(Exception $e){
		print $this->getMessage("Es ist ein unerwarteter Fehler aufgetreten", 
							"[".$e->getCode()."] ".$e->getMessage().", class: ".get_class($e), 
							MessagePrinter::ErrorMessage);
    }
	public function printError($code, $msg, $line, $file){
		switch ($code) {
		case E_USER_ERROR:
			$text = "Benutzerfehler";
			$type = MessagePrinter::ErrorMessage;
			break;
		case E_USER_WARNING:
			$text = "Benutzerwarnung";
			$type = MessagePrinter::WarningMessage;
			break;
		case E_USER_NOTICE:
			$text = "Benutzermeldung";
			$type = MessagePrinter::InformationMessage;
			break;
		default:
			$text = "Unerwarteter Fehler";
			$type = MessagePrinter::ErrorMessage;
			break;
		}
		print MessageControler::getMessage($text, "[$code] $msg, line: $line, file: $file", $type);
	}
	public function getMessage($title, $msg, $type){
		switch ($type) {
		case MessagePrinter::InformationMessage:
			$box = $this->getMessageBox($msg, $title, "alert-info");
			break;
		case MessagePrinter::SuccessMessage:
			$box = $this->getMessageBox($msg, $title, "alert-success");
			break;
		case MessagePrinter::WarningMessage:
			$box = $this->getMessageBox($msg, $title, "alert-warning");
			break;
		default:
			$box = $this->getMessageBox($msg, $title, "alert-error");
			break;
		}
		return $box;
	}
	public function getMessageBox($msg, $title = "", $type = "alert-error", $closeButtonVisible = true){
		$messageBox = new HTMLContainer();
		$messageBox->addClassName("alert");
		$messageBox->addClassName($type);
		if($closeButtonVisible){
			$closeButton = new HTMLButton("&times;");
			$closeButton->addClassName("close");
			$closeButton->addAttribute("data-dismiss", "alert");
			$messageBox->addContent($closeButton);
		}
		if($title != ""){
			$titleText = new HTMLText($title);
			$titleText->setTag("h4");
			$messageBox->addContent($titleText);
		}
		$messageBox->addContent(new HTMLText($msg));
		$messageBox->addAttribute("z-index", "1000");
		$test = new HTMLContainer();
		$test->addContent($messageBox);
		return $test;
	}
}


?>