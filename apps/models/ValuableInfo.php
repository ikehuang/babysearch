<?php

class ValuableInfo extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("valuable_info");
	}
}