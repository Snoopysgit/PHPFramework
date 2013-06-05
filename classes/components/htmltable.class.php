<?php
namespace phpframework\components;

class HTMLTable extends HTMLContainer{
	public function __construct($values = ""){
		parent::__construct($values);
		$this->setTag("table");
		$this->addClassName("table table-condensed");
	}
}
class HTMLTableHead extends HTMLContainer{
	public function __construct($values = ""){
		parent::__construct($values);
		$this->setTag("thead");
	}
}
class HTMLTableBody extends HTMLContainer{
	public function __construct($values = ""){
		parent::__construct($values);
		$this->setTag("tbody");
	}
}
class HTMLTableRow extends HTMLContainer{
	public function __construct($values = ""){
		parent::__construct($values);
		$this->setTag("tr");
	}
}
class HTMLTableCell extends HTMLContainer{
	public function __construct($values = ""){
		parent::__construct($values);
		$this->setTag("td");
	}
}
class HTMLTableHeadCell extends HTMLTableCell{
	public function __construct($values = ""){
		parent::__construct($values);
		$this->setTag("th");
	}
}
?>