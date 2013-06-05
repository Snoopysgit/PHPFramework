<?php
namespace phpframework\controlers;

class ContentControler extends Controler{
	private $navigatorsByCategory;
	private $navigatorsById;
	
	protected function __construct(){
		parent::__construct();
		$navigators = array();
	}
}
?>