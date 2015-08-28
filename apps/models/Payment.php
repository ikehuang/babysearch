<?php

class Payment extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("payments");
	}
}