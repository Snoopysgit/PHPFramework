<?php
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
	}
	private function initComponents(){
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
		$this->buttonLogin->setText("Login");
		$this->buttonLogin->setValue("LOGIN");
		$this->buttonLogout->setText("Logout");
		$this->buttonLogout->setValue("LOGOUT");
	}
	private function loginForm(){
			
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
		return $this->form;
	}
	private function logoutForm(){
		
		$firstname = LoginControler::singleton()->getLogin()->getValue("firstname");
		$lastname = LoginControler::singleton()->getLogin()->getValue("lastname");
		
		$this->form->addContent(new HTMLTitle($firstname." ".$lastname));
		$this->form->addContent($this->buttonLogout);
		$this->form->addClassName("navbar-form"); 
		$this->form->addClassName("pull-right");
		return $this->form;
	}
	public function refreshHTML(){
		$innerNav = new HTMLContainer();
		$innerNav->addClassName("navbar-inner");
		
		$title = new HTMLTitle("MArV Mitarbeiterverwaltung");
		$innerNav->addContent($title);
				
		if(LoginControler::singleton()->isLoggedIn()){
			$innerNav->addContent($this->logoutForm());
		}else{
			$innerNav->addContent($this->loginForm());
			if(isset($_POST[$this->inputLoginName->getName()])){
				$innerNav->addContent(MessageControler::getMessage("Falsche eingaben", "Benutzername oder Passwort falsch!", MessagePrinter::ErrorMessage));
			}
		}
		
		$this->setInnerHTML($innerNav);
	}	
} 

?>