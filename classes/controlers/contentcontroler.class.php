<?php
class ContentControler extends AbstractControler{
	private $navigatorsByCategory;
	private $navigatorsById;
	
	protected function __construct(){
		parent::__construct();
		$navigators = array();
	}
}
?>