<?php
namespace phpframework\controlers;

/**
 * Message controler
 * 
 * Provides basic functionalities to track and print exceptions or to print error messages to the user
 * @author Christian Thommen
 */
class MessageControler extends Controler{
	/**
	 * holds the printer
	 */
	private $printer;
	/**
	 * Creates a new instance
	 *
	 * Sets the printer to a new DefaultMessagePrinter()
	 */
	protected function __construct(){
		parent::__construct();
		$this->setPrinter(new DefaultMessagePrinter());
	}
	/**
	 * handle an exception and print the exception to the user
	 * it depends on the printer, where and how the exception is printed
	 */
    public static function handleException(Exception $e){
		MessageControler::singleton()->getPrinter()->printException($e);
    }
	/**
	 * handle an error and print the error to the user
	 * it depends on the printer, where and how the error is printed
	 */
    public static function handleError($code, $msg, $file, $line){
		MessageControler::singleton()->getPrinter()->printError($code, $msg, $file, $line);
    }
	/**
	 * Set a printer
	 * 
	 * @param MessagePrinter $printer provide a new printer, that implements the MessagePrinter interface
	 */
	public function setPrinter(MessagePrinter $printer){
		$this->printer = $printer;
	}
	/**
	 * Get the printer
	 */
	public function getPrinter(){
		return $this->printer;
	}
	/**
	 * Set a Printer
	 * 
	 * @param MessagePrinter $printer provide a new printer, that implements the MessagePrinter interface
	 */
	public static function getMessage($titel, $msg, $type){
		return MessageControler::singleton()->getPrinter()->getMessage($titel, $msg, $type);
	}
}

/**
 * MessagePrinter interface
 *
 * Can be used to implement different printing behaviouers for exceptions/errors
 */
interface MessagePrinter{
	/**
	 * InformationMessage constant(as php has no nativ enums, you can use MessagePrinter::InformationMessage now)
	 */
	const InformationMessage = 0;
	/**
	 * constant(as php has no nativ enums, you can use MessagePrinter::SuccessMessage now)
	 */
	const SuccessMessage = 1;
	/**
	 * constant(as php has no nativ enums, you can use MessagePrinter::ErrorMessage now)
	 */
	const ErrorMessage = 2;
	/**
	 * constant(as php has no nativ enums, you can use MessagePrinter::WarningMessage now)
	 */
	const WarningMessage = 3;
	
	/**
	 * Prints an Exception
	 * 
	 * It depends on the specific class how the message is handled
	 * @param Exception $e provide an exception to handle here
	 */
    public function printException(Exception $e);
	/**
	 * Prints an Error
	 * 
	 * It depends on the specific class how the message is handled
	 * @param ERRORCODE $code error code
	 * @param string $message body of the message
	 * @param string $file file name where the error happened
	 * @param string $line line number where the error happened
	 */
	public function printError($code, $message, $file, $line);
	/**
	 * Gets a message
	 * 
	 * It depends on the specific class how the message is handled
	 * @param string $titel title of this message
	 * @param string $message body of the message
	 * @param MessagePrinter::constant $type message type(MessagePrinter::constants)
	 */
	public function getMessage($titel, $message, $type);
}

use phpframework\components\HTMLContainer;
use phpframework\components\HTMLButton;
use phpframework\components\HTMLText;
use phpframework\components\HTMLTitle;

/**
 * Implements a basic MessagePrinter
 *
 * Prints exceptions directly to the user. The messages will be well formated.
 */
class DefaultMessagePrinter implements MessagePrinter{
    public function printException(Exception $e){
		print $this->getMessage("Es ist ein unerwarteter Fehler aufgetreten", 
							"[".$e->getCode()."] ".$e->getMessage().", class: ".get_class($e), 
							MessagePrinter::ErrorMessage);
    }
	public function printError($code, $msg, $file, $line){
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
	/**
	 * Get a well formatted message box
	 *
	 * @param string $msg the message to print
	 * @param string $title the title of the message
	 * @param string $type the type of error(bootstrap className)
	 * @param boolean $closeButtonVisible true, if the closeButton should be visible, false if not
	 */
	private function getMessageBox($msg, $title = "", $type = "alert-error", $closeButtonVisible = true){
		$messageBox = new HTMLContainer();
		$messageBox->addClassName("alert");
		$messageBox->addClassName($type);
		if($closeButtonVisible){
			$closeButton = new HTMLButton();
			$closeButton->setValue("&times;");
			$closeButton->addClassName("close");
			$closeButton->addAttribute("data-dismiss", "alert");
			$messageBox->addContent($closeButton);
		}
		if($title != ""){
			$titleText = new HTMLTitle($title);
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