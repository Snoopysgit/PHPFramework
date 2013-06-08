<?php
namespace phpframework\samples;
use phpframework\components\HTMLContainer;
use phpframework\components\HTMLInput;
use phpframework\components\HTMLSubmitButton;
use phpframework\components\HTMLTitle;
use phpframework\components\HTMLIcon;
use phpframework\modules\HTMLForm;
use phpframework\controlers\LoginControler;
use phpframework\controlers\MessageControler;
use phpframework\controlers\MessagePrinter;

class LoginBar extends HTMLContainer{
	private $form;
	private $inputLoginName;
	private $inputPassword;
	private $buttonLogin;
	private $buttonLogout;
	
	public function __construct(){
		parent::__construct();
		$this->initComponents();
		$this->addClassName("navbar");
		if( $this->buttonLogin->isActive()){
			LoginControler::singleton()->logIn($this->inputLoginName->getValue(),$this->inputPassword->getValue());
		}elseif($this->buttonLogout->isActive()){
			LoginControler::singleton()->logout();
		}
		if(LoginControler::singleton()->isLoggedIn()){
			$this->loadLogoutForm();
		}else{
			$this->loadLoginForm();
			if(isset($_POST[$this->inputLoginName->getName()])){
				$this->addContent(MessageControler::getMessage("Falsche eingaben", "Benutzername oder Passwort falsch!", MessagePrinter::ErrorMessage));
			}
		}
	}
	private function initComponents(){
		$navbarInner = new HTMLContainer();
		$navbarInner->addClassName("navbar-inner");
		
		$this->form = new HTMLForm();
		
		$this->inputLoginName = new HTMLInput();
		$this->inputLoginName->setRequired(true);
		$this->inputLoginName->setPlaceholder("Benutzername");
		$this->inputLoginName->addAttribute("style", "width:225px");
		if(isset($_POST[$this->inputLoginName->getName()])){
			$this->inputLoginName->setValue($_POST[$this->inputLoginName->getName()]);
		}
		
		$this->inputPassword = new HTMLInput();
		$this->inputPassword->setType("password");
		$this->inputPassword->setRequired(true);
		$this->inputPassword->setPlaceholder("Passwort");
		
		$this->buttonLogin = new HTMLSubmitButton();
		$this->buttonLogout = new HTMLSubmitButton();
		$this->buttonLogin->setValue("Login");
		$this->buttonLogout->setValue("Logout");
		
		
		$title = new HTMLTitle("MArV Mitarbeiterverwaltung");
		$title->addClassName("brand");
		$navbarInner->addContent($title);
		$navbarInner->addContent($this->form);
		$this->addContent($navbarInner);
	}
	private function loadLoginForm(){
		$container = new HTMLContainer();
		$container->addClassName("input-prepend");
		$container->addClassName("span4");
		$loginnameIcon = new HTMLIcon("icon-user");
		$iconholder = new HTMLContainer();
		$iconholder->setTag("span");
		$iconholder->addClassName("add-on");
		$iconholder->addContent($loginnameIcon);
		$container->addContent($iconholder);
		$container->addContent($this->inputLoginName);
		
		$this->form->addContent($container);
		$this->form->addContent($this->inputPassword);
		$this->form->addContent($this->buttonLogin);
		
		$this->form->addClassName("navbar-form");
	}
	private function loadLogoutForm(){		
		$firstname = LoginControler::singleton()->getLogin()->getValue("firstname");
		$lastname = LoginControler::singleton()->getLogin()->getValue("lastname");
		$title = new HTMLTitle($firstname." ".$lastname);
		$title->addClassName("brand");
		$this->form->addContent($title);
		$this->form->addContent($this->buttonLogout);
		$this->form->addClassName("navbar-form"); 
		$this->form->addClassName("pull-right");
	}
} 

?>